<?php

namespace App\Traits;

use App\Jobs\ProcessUploadedUserAvatarJob;
use Illuminate\Support\Facades\Storage;

trait HandlesAvatar
{
    public function saveAvatar(): void
    {
        $this->validate(['avatar' => ['required', 'image', 'max:2048']]);

        $fileName = uniqid() . '.' . config('avatar.image_type');
        $stored = $this->avatar->storeAs(config('avatar.original_path'), $fileName, 'public');

        if ($stored) {
            auth()->user()->update(['avatar_path' => $fileName]);
            ProcessUploadedUserAvatarJob::dispatchSync($stored, $fileName);
        }

        $this->avatar = null;
    }

    public function deleteAvatar(): void
    {
        $user = auth()->user();

        if (!$user->avatar_path) return;

        Storage::disk('public')->delete(config('avatar.original_path') . '/' . $user->avatar_path);

        foreach (config('avatar.sizes') as $size) {
            $path = sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']);
            Storage::disk('public')->delete($path . '/' . $user->avatar_path);
        }

        $user->update(['avatar_path' => null]);
    }
}
