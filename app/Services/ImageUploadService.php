<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploadService
{
    protected $manager;

    public function __construct()
    {
        // Initialize ImageManager with GD driver (or Imagick if available)
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Upload image dengan resize dan optimization
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $folder
     * @param int|null $maxWidth
     * @param int|null $maxHeight
     * @param int $quality Quality for JPEG/WebP (0-100), default 85
     * @return string|null
     */
    public function upload($image, $folder = 'uploads', $maxWidth = 1200, $maxHeight = null, $quality = 85)
    {
        if (!$image || !$image->isValid()) {
            return null;
        }

        try {
            // Generate unique filename
            $filename = $this->generateFilename($image);
            
            // Full path
            $path = $folder . '/' . $filename;
            
            // Read and process image
            $imageResource = $this->manager->read($image->getRealPath());
            
            // Get original dimensions for aspect ratio calculation
            $originalWidth = $imageResource->width();
            $originalHeight = $imageResource->height();
            
            // Resize if needed (maintain aspect ratio)
            if ($maxWidth && $originalWidth > $maxWidth) {
                if ($maxHeight) {
                    // Scale to fit within both dimensions
                    $imageResource->scale(width: $maxWidth, height: $maxHeight);
                } else {
                    // Scale width only, height auto
                    $imageResource->scale(width: $maxWidth);
                }
            }
            
            // Encode with quality optimization
            $extension = strtolower($image->getClientOriginalExtension());

            switch ($extension) {
                case 'png':
                    // PNG: use optimization level (0-9)
                    $encoded = $imageResource->toPng();
                    break;
                case 'webp':
                    // WebP: excellent compression with good quality
                    $encoded = $imageResource->toWebp(quality: $quality);
                    break;
                case 'jpg':
                case 'jpeg':
                    // JPEG: standard compression
                    $encoded = $imageResource->toJpeg(quality: $quality);
                    break;
                default:
                    // Default to JPEG for unknown formats
                    $encoded = $imageResource->toJpeg(quality: $quality);
                    break;
            }
            
            // Save to storage
            Storage::disk('public')->put($path, (string) $encoded);
            
            Log::info("Image uploaded successfully: {$path} (Original: {$originalWidth}x{$originalHeight}, Quality: {$quality})");
            
            return $path;
            
        } catch (\Exception $e) {
            Log::error('Image upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Upload multiple images
     *
     * @param array $images
     * @param string $folder
     * @return array
     */
    public function uploadMultiple(array $images, $folder = 'uploads')
    {
        $uploadedPaths = [];
        
        foreach ($images as $image) {
            $path = $this->upload($image, $folder);
            if ($path) {
                $uploadedPaths[] = $path;
            }
        }
        
        return $uploadedPaths;
    }

    /**
     * Delete image from storage
     *
     * @param string|null $path
     * @return bool
     */
    public function delete($path)
    {
        if (!$path) {
            return false;
        }

        try {
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->delete($path);
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Image delete failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete multiple images
     *
     * @param array $paths
     * @return int
     */
    public function deleteMultiple(array $paths)
    {
        $deletedCount = 0;
        
        foreach ($paths as $path) {
            if ($this->delete($path)) {
                $deletedCount++;
            }
        }
        
        return $deletedCount;
    }

    /**
     * Generate unique filename
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return string
     */
    protected function generateFilename($image)
    {
        $extension = $image->getClientOriginalExtension();
        $timestamp = time();
        $random = Str::random(10);
        
        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Get image URL from path
     *
     * @param string|null $path
     * @param string|null $default
     * @return string
     */
    public function getUrl($path, $default = null)
    {
        if (!$path) {
            return $default ?? asset('images/default-placeholder.jpg');
        }

        if (Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        return $default ?? asset('images/default-placeholder.jpg');
    }

    /**
     * Create thumbnail
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $folder
     * @param int $width
     * @param int $height
     * @param int $quality
     * @return string|null
     */
    public function createThumbnail($image, $folder = 'thumbnails', $width = 300, $height = 300, $quality = 80)
    {
        if (!$image || !$image->isValid()) {
            return null;
        }

        try {
            $filename = $this->generateFilename($image);
            $path = $folder . '/' . $filename;
            
            $imageResource = $this->manager->read($image->getRealPath());
            
            // Create thumbnail with cover (crop to fit)
            $imageResource->cover($width, $height);
            
            // Save as WebP for better compression
            $encoded = $imageResource->toWebp(quality: $quality);
            
            Storage::disk('public')->put($path, (string) $encoded);
            
            Log::info("Thumbnail created successfully: {$path}");
            
            return $path;
            
        } catch (\Exception $e) {
            Log::error('Thumbnail creation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create thumbnail from existing file path
     *
     * @param string $imagePath Path relative to storage/app/public
     * @param string $folder
     * @param int $width
     * @param int $height
     * @param int $quality
     * @return string|null
     */
    public function createThumbnailFromPath($imagePath, $folder = 'thumbnails', $width = 300, $height = 300, $quality = 80)
    {
        try {
            // Try to get file content from Storage facade (works with fake storage in tests)
            if (!Storage::disk('public')->exists($imagePath)) {
                Log::error("Thumbnail source file not found in storage: {$imagePath}");
                return null;
            }

            // Get file content from storage
            $fileContent = Storage::disk('public')->get($imagePath);
            
            // Load image from content
            $imageResource = $this->manager->read($fileContent);
            
            // Generate unique thumbnail filename (use WebP for better compression)
            $timestamp = time();
            $random = Str::random(8);
            $filename = "thumb_{$timestamp}_{$random}.webp";
            $thumbnailPath = $folder . '/' . $filename;
            
            // Create thumbnail with cover
            $imageResource->cover($width, $height);
            $encoded = $imageResource->toWebp(quality: $quality);
            
            // Save thumbnail
            Storage::disk('public')->put($thumbnailPath, (string) $encoded);
            
            Log::info("Thumbnail created from path: {$thumbnailPath}");
            
            return $thumbnailPath;
            
        } catch (\Exception $e) {
            Log::error('Thumbnail from path creation failed: ' . $e->getMessage());
            return null;
        }
    }
}
