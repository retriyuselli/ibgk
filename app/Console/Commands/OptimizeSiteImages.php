<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class OptimizeSiteImages extends Command
{
    protected $signature = 'images:optimize {--path=public/images : Relative path under project root}';

    protected $description = 'Compress JPEG assets and generate WebP variants for public site images';

    public function handle(): int
    {
        $root = base_path($this->option('path'));

        if (! is_dir($root)) {
            $this->error("Directory not found: {$root}");

            return self::FAILURE;
        }

        $files = iterator_to_array(new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS)
        ));

        /** @var list<SplFileInfo> $jpegFiles */
        $jpegFiles = array_values(array_filter(
            $files,
            fn (SplFileInfo $file): bool => $file->isFile() && preg_match('/\.jpe?g$/i', $file->getFilename()) === 1,
        ));

        if ($jpegFiles === []) {
            $this->warn('No JPEG files found.');

            return self::SUCCESS;
        }

        $before = 0;
        $after = 0;
        $webpCount = 0;

        foreach ($jpegFiles as $file) {
            $path = $file->getPathname();
            $before += $file->getSize();

            $maxWidth = str_contains($file->getFilename(), 'hero') ? 1920 : 1400;
            $quality = str_contains($file->getFilename(), 'hero') ? 82 : 80;

            if (! $this->compressJpeg($path, $maxWidth, $quality)) {
                $this->warn("Skipped: {$path}");

                continue;
            }

            $after += filesize($path);

            if ($this->createWebp($path, $quality)) {
                $webpCount++;
                $after += (int) filesize(preg_replace('/\.jpe?g$/i', '.webp', $path));
            }
        }

        $saved = max(0, $before - $after);
        $this->info(sprintf(
            'Optimized %d JPEG files, generated %d WebP files. Estimated payload: %s → %s (saved %s).',
            count($jpegFiles),
            $webpCount,
            $this->formatBytes($before),
            $this->formatBytes($after),
            $this->formatBytes($saved),
        ));

        return self::SUCCESS;
    }

    private function compressJpeg(string $path, int $maxWidth, int $quality): bool
    {
        if (PHP_OS_FAMILY === 'Darwin' && $this->compressJpegWithSips($path, $maxWidth, $quality)) {
            return true;
        }

        $image = @imagecreatefromjpeg($path);

        if ($image === false) {
            return false;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $targetHeight = (int) round($height * ($maxWidth / $width));
            $resized = imagecreatetruecolor($maxWidth, $targetHeight);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $maxWidth, $targetHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        $result = imagejpeg($image, $path, $quality);
        imagedestroy($image);

        return $result;
    }

    private function compressJpegWithSips(string $path, int $maxWidth, int $quality): bool
    {
        $temporary = $path.'.opt.jpg';

        $resize = proc_open(
            ['sips', '-Z', (string) $maxWidth, '-s', 'format', 'jpeg', '-s', 'formatOptions', (string) $quality, $path, '--out', $temporary],
            [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']],
            $pipes,
        );

        if (! is_resource($resize)) {
            return false;
        }

        fclose($pipes[0]);
        stream_get_contents($pipes[1]);
        stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $exitCode = proc_close($resize);

        if ($exitCode !== 0 || ! is_file($temporary)) {
            @unlink($temporary);

            return false;
        }

        return rename($temporary, $path);
    }

    private function createWebp(string $jpegPath, int $quality): bool
    {
        if (! function_exists('imagewebp')) {
            return false;
        }

        $webpPath = preg_replace('/\.jpe?g$/i', '.webp', $jpegPath);
        $image = @imagecreatefromjpeg($jpegPath);

        if ($image === false) {
            return false;
        }

        $result = imagewebp($image, $webpPath, $quality);
        imagedestroy($image);

        return $result && is_file($webpPath);
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1).' KB';
        }

        return $bytes.' B';
    }
}
