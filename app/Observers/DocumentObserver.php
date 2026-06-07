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

        $admins = User::where('role', UserRoles::ADMIN->value)->get();
        Notification::send($admins, new DocumentUploadedNotification($user));

        if (! $user->isIncomplete()) {
            return;
        }

        $hasCarteIdentite = $user->documents()->where('type', DocumentTypes::CARTE_IDENTITE)->exists();
        $hasCertificatMedical = $user->documents()->where('type', DocumentTypes::CERTIFICAT_MEDICAL)->exists();
        $hasCasierJudiciaire = $user->documents()->where('type', DocumentTypes::CASIER_JUDICIAIRE)->exists();

        if ($hasCarteIdentite && $hasCertificatMedical && $hasCasierJudiciaire) {
            $user->update(['status' => UserStatus::PENDING]);
            $user->notify(new MemberChangedNotification(newStatus: UserStatus::PENDING->label()));
        }
    }
}
