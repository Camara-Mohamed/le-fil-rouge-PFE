<?php

namespace App\Traits;

use App\Jobs\ProcessUploadedUserAvatarJob;
use Illuminate\Support\Facades\Storage;

trait HandlesAvatar
{
    public function saveAvatar(): void
    {
        $this->validate(['avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048']]);

        $user = auth()->user();

        if ($user->avatar_path) {
            Storage::disk(config('filesystems.default'))->delete(config('avatar.original_path').'/'.$user->avatar_path);
            foreach (config('avatar.sizes') as $size) {
                $path = sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']);
                Storage::disk(config('filesystems.default'))->delete($path.'/'.$user->avatar_path);
            }
        }

        $fileName = uniqid().'.'.config('avatar.image_type');
        $stored = $this->avatar->storeAs(config('avatar.original_path'), $fileName, config('filesystems.default'));

        if ($stored) {
            $user->update(['avatar_path' => $fileName]);
            ProcessUploadedUserAvatarJob::dispatchSync($stored, $fileName);
        }

        $this->avatar = null;
        $this->dispatch('toast', message: __('toast/profile.avatar_updated'), type: 'success');
    }

    public function deleteAvatar(): void
    {
        $user = auth()->user();

        if (! $user->avatar_path) {
            return;
        }

        Storage::disk(config('filesystems.default'))->delete(config('avatar.original_path').'/'.$user->avatar_path);

        foreach (config('avatar.sizes') as $size) {
            $path = sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']);
            Storage::disk(config('filesystems.default'))->delete($path.'/'.$user->avatar_path);
        }

        $user->update(['avatar_path' => null]);
        $this->dispatch('toast', message: __('toast/profile.avatar_deleted'), type: 'success');
    }
}
