<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProcessUploadedImage implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $storedPath,
        public string $variantsPath,
        public array $sizes,
    ) {}

    public function handle(): void
    {
        $image = Image::read(Storage::disk('s3')->get($this->storedPath));
        $quality = config('banners.quality');
        $type = config('banners.image_type');
        $name = pathinfo(basename($this->storedPath), PATHINFO_FILENAME).'.'.$type;

        foreach ($this->sizes as $width) {
            $variant = clone $image;
            $variant->scale($width);

            Storage::disk('s3')->put(
                $this->variantsPath.'/'.$width.'/'.$name,
                $variant->encodeByExtension($type, quality: $quality)
            );
        }
    }
}
