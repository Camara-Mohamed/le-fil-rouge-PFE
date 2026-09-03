<?php

namespace App\Observers;

use App\Enums\DocumentTypes;
use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Models\Document;
use App\Models\User;
use App\Notifications\DocumentUploadedNotification;
use App\Notifications\MemberChangedNotification;
use Illuminate\Support\Facades\Notification;

class DocumentObserver
{
    public function created(Document $document): void
    {
        $user = $document->user;

        try {
            $admins = User::where('role', UserRoles::ADMIN->value)->get();
            foreach ($admins as $admin) {
                $admin->notify(new DocumentUploadedNotification($user));
            }
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new DocumentUploadedNotification($user));
        } catch (\Throwable) {
        }

        if (! $user->isIncomplete()) {
            return;
        }

        $hasCarteIdentite = $user->documents()->where('type', DocumentTypes::CARTE_IDENTITE)->exists();
        $hasCertificatMedical = $user->documents()->where('type', DocumentTypes::CERTIFICAT_MEDICAL)->exists();
        $hasCasierJudiciaire = $user->documents()->where('type', DocumentTypes::CASIER_JUDICIAIRE)->exists();

        if ($hasCarteIdentite && $hasCertificatMedical && $hasCasierJudiciaire) {
            $user->update(['status' => UserStatus::PENDING]);
            try {
                $user->notify(new MemberChangedNotification(newStatus: UserStatus::PENDING->label()));
                Notification::route('mail', config('mail.notification_for_mails'))->notify(new MemberChangedNotification(newStatus: UserStatus::PENDING->label()));
            } catch (\Throwable) {
            }
        }
    }

    public function deleted(Document $document): void
    {
        $user = $document->user;

        if (! in_array($user->status, [UserStatus::PENDING, UserStatus::COMPLETE], true)) {
            return;
        }

        $hasCarteIdentite = $user->documents()->where('type', DocumentTypes::CARTE_IDENTITE)->exists();
        $hasCertificatMedical = $user->documents()->where('type', DocumentTypes::CERTIFICAT_MEDICAL)->exists();
        $hasCasierJudiciaire = $user->documents()->where('type', DocumentTypes::CASIER_JUDICIAIRE)->exists();

        if ($hasCarteIdentite && $hasCertificatMedical && $hasCasierJudiciaire) {
            return;
        }

        $user->update(['status' => UserStatus::INCOMPLETE]);
        try {
            $user->notify(new MemberChangedNotification(newStatus: UserStatus::INCOMPLETE->label()));
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new MemberChangedNotification(newStatus: UserStatus::INCOMPLETE->label()));
        } catch (\Throwable) {
        }
    }
}
