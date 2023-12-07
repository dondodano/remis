<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum UserRole: string implements HasColor{
    case Super = 'super';
    case Admin = 'admin';
    case REMIS = 'remis';
    case Proponent = 'proponent';
    case PlanningOfficer = 'planningofficer';
    case BudgetOfficer = 'budgetofficer';
    case RIDEDirector = 'ridedirector';
    case AccountingOfficer = 'accountingofficer';
    case RIDEStaff = 'ridestaff';

    public function getLabel(): ?string{
        return match ($this)
        {
            self::Super => 'success',
            self::Admin => 'success',
            self::REMIS => 'success',
            self::Proponent => 'warning',
            self::PlanningOfficer => 'info',
            self::BudgetOfficer => 'danger',
            self::RIDEDirector => 'gray',
            self::AccountingOfficer => 'danger',
            self::RIDEStaff => 'gray',
        };
    }
}
