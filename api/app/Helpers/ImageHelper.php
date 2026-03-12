<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageHelper
{
    protected static function manager()
    {
        return new ImageManager(new Driver());
    }

    /**
     * Convert full URL -> storage path
     */
    protected static function pathFromUrl($url)
    {
        if (!$url) return null;

        return str_replace(Storage::url(''), '', $url);
    }

    /** 
     * Upload single image
     */
    public static function uploadSingle($file, $folder, $oldFile = null, $width = 800)
    {
        if (!$file) return null;

        $manager = self::manager();

        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $filename = time() . '-' . Str::slug($name) . '.webp';

        $path = "uploads/$folder/$filename";

        $image = $manager->read($file);

        $image->scale(width: $width);

        $encoded = $image->toWebp(80);

        Storage::disk('public')->put($path, $encoded);

        /**
         * Delete old image (support full URL)
         */
        if ($oldFile) {

            $oldPath = self::pathFromUrl($oldFile);

            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        return Storage::url($path);
    }

    /**
     * Upload multiple images
     */
    public static function uploadMultiple($files, $folder, $width = 1200)
    {
        if (!$files) return [];

        $manager = self::manager();

        $time = time();

        $images = [];

        foreach ($files as $index => $file) {

            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $filename = $time . '-' . Str::slug($name) . "-$index.webp";

            $path = "uploads/$folder/$filename";

            $image = $manager->read($file);

            $image->scale(width: $width);

            $encoded = $image->toWebp(80);

            Storage::disk('public')->put($path, $encoded);

            $images[] = Storage::url($path);
        }

        return $images;
    }

    /**
     * Delete single image
     */
    public static function delete($image)
    {
        if (!$image) return;

        $path = self::pathFromUrl($image);

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Delete multiple images
     */
    public static function deleteMultiple($images)
    {
        if (!$images) return;

        foreach ($images as $image) {

            $path = self::pathFromUrl($image);

            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    /**
     * Return image URL
     */
    public static function url($path)
    {
        return $path ? Storage::url($path) : null;
    }
}
