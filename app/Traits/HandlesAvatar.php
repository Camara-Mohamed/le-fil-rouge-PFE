<?php

namespace App\Traits;

use App\Jobs\ProcessUploadedUserAvatarJob;

trait HandlesAvatar
{
    public function saveAvatar(): void
    {
        $this->validate(['avatar' => ['required', 'image', 'max:2048']]);

        $fileName = uniqid() . '.' . config('avatar.image_type');
        $stored = $this->avatar->storeAs(config('avatar.original_path'), $fileName, 'public');

        if ($stored) {
            auth()->user()->update(['avatar_path' => $fileName]);
            ProcessUploadedUserAvatarJob::dispatch($stored, $fileName);
        }

        $this->avatar = null;
    }
}
