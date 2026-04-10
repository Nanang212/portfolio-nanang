<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload to S3 with WebP conversion.
     */
    public function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        $webp     = $this->convertToWebP($file);
        $filename = Str::uuid() . '.webp';
        Storage::disk('s3')->put("{$folder}/{$filename}", $webp);
        return "{$folder}/{$filename}";
    }

    /**
     * Upload to local public disk with WebP conversion.
     */
    public function uploadLocal(UploadedFile $file, string $folder = 'uploads'): string
    {
        $webp     = $this->convertToWebP($file);
        $filename = Str::uuid() . '.webp';
        $path     = "{$folder}/{$filename}";
        Storage::disk('public')->put($path, $webp);
        return $path;
    }

    /**
     * Convert any uploaded image to WebP binary string, with auto-resize.
     * Falls back to original bytes if GD is unavailable or conversion fails.
     *
     * @param  int  $quality   WebP quality 0-100 (default 85)
     * @param  int  $maxWidth  Max output width/height in px (default 1920)
     */
    public function convertToWebP(UploadedFile $file, int $quality = 85, int $maxWidth = 1920): string
    {
        if (!extension_loaded('gd') || !function_exists('imagewebp')) {
            return file_get_contents($file->getRealPath());
        }

        $mime = $file->getMimeType();
        $src  = $file->getRealPath();

        $image = match (true) {
            str_contains($mime, 'jpeg') || str_contains($mime, 'jpg') => @imagecreatefromjpeg($src),
            str_contains($mime, 'png')                                 => @imagecreatefrompng($src),
            str_contains($mime, 'gif')                                 => @imagecreatefromgif($src),
            str_contains($mime, 'webp')                                => @imagecreatefromwebp($src),
            str_contains($mime, 'bmp')                                 => @imagecreatefrombmp($src),
            default                                                    => false,
        };

        if (!$image) {
            return file_get_contents($src);
        }

        // Preserve transparency for PNG/GIF
        if (str_contains($mime, 'png') || str_contains($mime, 'gif')) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        // Auto-resize if either dimension exceeds $maxWidth
        $origW = imagesx($image);
        $origH = imagesy($image);

        if ($origW > $maxWidth || $origH > $maxWidth) {
            if ($origW >= $origH) {
                $newW = $maxWidth;
                $newH = (int) round($origH * ($maxWidth / $origW));
            } else {
                $newH = $maxWidth;
                $newW = (int) round($origW * ($maxWidth / $origH));
            }

            $resized = imagecreatetruecolor($newW, $newH);

            // Preserve transparency on resize
            if (str_contains($mime, 'png') || str_contains($mime, 'gif')) {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
                imagefilledrectangle($resized, 0, 0, $newW, $newH, $transparent);
            }

            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
            imagedestroy($image);
            $image = $resized;
        }

        ob_start();
        imagewebp($image, null, $quality);
        $webp = ob_get_clean();
        imagedestroy($image);

        return $webp;
    }

    public function delete(?string $path): void
    {
        if (!$path) return;
        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
        } elseif (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function url(string $path): string
    {
        try {
            return Storage::disk('s3')->url($path);
        } catch (\Exception $e) {
            return Storage::disk('public')->url($path);
        }
    }
}
