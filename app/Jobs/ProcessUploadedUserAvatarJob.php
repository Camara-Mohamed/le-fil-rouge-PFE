<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProcessUploadedUserAvatarJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $full_path_to_original,
        public string $file_name
    ) {}

    public function handle(): void
    {
        $image = Image::decode(Storage::disk('public')->get($this->full_path_to_original));

        foreach (config('avatar.sizes') as $size) {
            $variant = clone $image;
            $variant->scale($size['width']);

            $path = sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']);
            Storage::disk('public')->put(
                $path . '/' . $this->file_name,
                $variant->encodeUsingFileExtension(config('avatar.image_type'), config('avatar.jpeg_compression'))
            );
        }
    }
}
