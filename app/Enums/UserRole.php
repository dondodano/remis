<?php
namespace App\Enums;

use Filament\Notifications\Notification;
use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel{
    case Super = 'super';
    case Admin = 'admin';
    case REMIS = 'remis';
    case Proponent = 'proponent';
    case PlanningOfficer = 'planningofficer';
    case BudgetOfficer = 'budgetofficer';
    case RIDEDirector = 'ridedirector';
    case AccountingOfficer = 'accountingofficer';
    case RIDEStaff = 'ridestaff';
    case Guest = 'guest';

    public function getLabel(): ?string
    {
        return match ($this)
        {
            self::Super => 'Super',
            self::Admin => 'Admin',
            self::REMIS => 'REMIS',
            self::Proponent => 'Proponent',
            self::PlanningOfficer => 'Planning Officer',
            self::BudgetOfficer => 'Budget Officer',
            self::RIDEDirector => 'RIDE Director',
            self::AccountingOfficer => 'Accounting Officer',
            self::RIDEStaff => 'RIDE Staff',
            self::Guest => 'Guest'
        };
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function specificValues($excludedCases): array
    {
        $array = self::array();

        try{
            switch(gettype($excludedCases))
            {
                case 'string':
                    unset($array[$excludedCases]);
                    break;

                case 'array':
                    foreach($excludedCases as &$arrayIndex)
                    {
                        unset($array[$arrayIndex]);
                    }
                    break;
            }
        }catch(Exception $e){
            Notification::make()
                ->title("Error!")
                ->body('Error message => '. $e->getMessage())
                ->danger()
                ->duration(2000)
                ->send();
        }
        return $array;
    }
}
