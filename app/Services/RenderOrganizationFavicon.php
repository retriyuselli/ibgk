<?php

namespace App\Services;

use App\Models\OrganizationProfile;
use Illuminate\Support\Facades\Storage;

class RenderOrganizationFavicon
{
    public function png(?OrganizationProfile $profile, int $size = 32): string
    {
        if ($profile !== null && filled($profile->logo) && Storage::disk('public')->exists($profile->logo)) {
            $png = $this->fromLogoFile(Storage::disk('public')->path($profile->logo), $size);

            if ($png !== null) {
                return $png;
            }
        }

        return $this->defaultPng($size);
    }

    private function fromLogoFile(string $path, int $size): ?string
    {
        $image = $this->loadImage($path);

        if ($image === false) {
            return null;
        }

        $canvas = imagecreatetruecolor($size, $size);
        $background = imagecolorallocate($canvas, 11, 31, 58);
        imagefill($canvas, 0, 0, $background);

        $sourceWidth = imagesx($image);
        $sourceHeight = imagesy($image);
        $scale = min(($size - 8) / $sourceWidth, ($size - 8) / $sourceHeight);
        $targetWidth = max(1, (int) round($sourceWidth * $scale));
        $targetHeight = max(1, (int) round($sourceHeight * $scale));
        $offsetX = (int) floor(($size - $targetWidth) / 2);
        $offsetY = (int) floor(($size - $targetHeight) / 2);

        imagecopyresampled(
            $canvas,
            $image,
            $offsetX,
            $offsetY,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $sourceWidth,
            $sourceHeight,
        );

        imagedestroy($image);

        return $this->toPng($canvas);
    }

    private function defaultPng(int $size): string
    {
        $canvas = imagecreatetruecolor($size, $size);
        $navy = imagecolorallocate($canvas, 11, 31, 58);
        $gold = imagecolorallocate($canvas, 201, 162, 39);

        imagefill($canvas, 0, 0, $navy);

        $center = (int) round($size / 2);
        $radius = (int) round($size * 0.34);
        imagefilledellipse($canvas, $center, $center, $radius * 2, $radius * 2, $gold);

        $text = 'I';
        $fontSize = max(3, (int) round($size * 0.34));
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textHeight = imagefontheight($fontSize);
        $textColor = imagecolorallocate($canvas, 11, 31, 58);
        imagestring(
            $canvas,
            $fontSize,
            (int) floor($center - ($textWidth / 2)),
            (int) floor($center - ($textHeight / 2)),
            $text,
            $textColor,
        );

        return $this->toPng($canvas);
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
            str_contains($mime, 'svg') => false,
            default => false,
        };
    }

    private function toPng(\GdImage $image): string
    {
        ob_start();
        imagepng($image);
        imagedestroy($image);

        return (string) ob_get_clean();
    }
}
