<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class StoreCompressedImage
{
    public function store(
        UploadedFile $file,
        string $directory,
        string $disk = 'public',
        ?int $maxDimension = null,
        ?int $quality = null,
    ): string {
        $maxDimension ??= (int) config('site.profile_photo_max_dimension', config('site.alumni_profile_photo_max_dimension', 1000));
        $quality ??= (int) config('site.profile_photo_quality', config('site.alumni_profile_photo_quality', 82));

        $directory = trim($directory, '/');
        $filename = Str::uuid()->toString().'.jpg';
        $relativePath = $directory.'/'.$filename;

        Storage::disk($disk)->makeDirectory($directory);

        $fullPath = Storage::disk($disk)->path($relativePath);

        if (! $this->compressToJpeg($file->getRealPath(), $fullPath, $maxDimension, $quality)) {
            throw new RuntimeException('Gagal memproses foto. Pastikan file berupa gambar JPEG, PNG, atau WebP.');
        }

        return $relativePath;
    }

    public function delete(?string $path, string $disk = 'public'): void
    {
        if (blank($path)) {
            return;
        }

        Storage::disk($disk)->delete($path);
    }

    private function compressToJpeg(string $sourcePath, string $destinationPath, int $maxDimension, int $quality): bool
    {
        $image = $this->loadImage($sourcePath);

        if ($image === false) {
            return false;
        }

        $image = $this->applyExifOrientation($image, $sourcePath);
        $image = $this->resize($image, $maxDimension);
        $image = $this->flatten($image);

        $result = imagejpeg($image, $destinationPath, $quality);
        imagedestroy($image);

        return $result && is_file($destinationPath);
    }

    /** @return \GdImage|false */
    private function loadImage(string $path): \GdImage|false
    {
        $mime = mime_content_type($path) ?: '';

        return match (true) {
            str_contains($mime, 'jpeg'), str_contains($mime, 'jpg') => @imagecreatefromjpeg($path),
            str_contains($mime, 'png') => @imagecreatefrompng($path),
            str_contains($mime, 'webp') => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            str_contains($mime, 'gif') => @imagecreatefromgif($path),
            default => false,
        };
    }

    private function applyExifOrientation(\GdImage $image, string $path): \GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($path);

        if (! is_array($exif) || empty($exif['Orientation'])) {
            return $image;
        }

        return match ((int) $exif['Orientation']) {
            2 => $this->flipHorizontal($image),
            3 => imagerotate($image, 180, 0) ?: $image,
            4 => $this->flipVertical($image),
            5 => $this->flipHorizontal(imagerotate($image, -90, 0) ?: $image),
            6 => imagerotate($image, -90, 0) ?: $image,
            7 => $this->flipHorizontal(imagerotate($image, 90, 0) ?: $image),
            8 => imagerotate($image, 90, 0) ?: $image,
            default => $image,
        };
    }

    private function resize(\GdImage $image, int $maxDimension): \GdImage
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $longest = max($width, $height);

        if ($longest <= $maxDimension) {
            return $image;
        }

        $ratio = $maxDimension / $longest;
        $targetWidth = (int) round($width * $ratio);
        $targetHeight = (int) round($height * $ratio);

        $resized = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        imagedestroy($image);

        return $resized;
    }

    private function flatten(\GdImage $image): \GdImage
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $flattened = imagecreatetruecolor($width, $height);
        $background = imagecolorallocate($flattened, 255, 255, 255);

        imagefill($flattened, 0, 0, $background);
        imagecopy($flattened, $image, 0, 0, 0, 0, $width, $height);
        imagedestroy($image);

        return $flattened;
    }

    private function flipHorizontal(\GdImage $image): \GdImage
    {
        if (function_exists('imageflip')) {
            imageflip($image, IMG_FLIP_HORIZONTAL);
        }

        return $image;
    }

    private function flipVertical(\GdImage $image): \GdImage
    {
        if (function_exists('imageflip')) {
            imageflip($image, IMG_FLIP_VERTICAL);
        }

        return $image;
    }
}
