<?php
namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserVerificationStatus: string implements HasLabel{
    case Verified = 'verified';
    case Unverified = '';

    public function getLabel(): ?string{
        return match ($this)
        {
            self::Verified => 'Verified',
            self::Unverified => '',
        };
    }
}
