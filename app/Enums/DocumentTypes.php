<?php

namespace App\Enums;

enum DocumentTypes: string
{
    case CARTE_IDENTITE = 'carte_identite';
    case CERTIFICAT_MEDICAL = 'certificat_medical';
    case CASIER_JUDICIAIRE = 'casier_judiciaire';
    case AUTRE = 'other';

    public function label(): string
    {
        return __("enums.document_types.{$this->value}");
    }
}
