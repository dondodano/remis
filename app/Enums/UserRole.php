<?php
namespace App\Enums;

use Filament\Notifications\Notification;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasDescription;

enum UserRole: string implements HasLabel, HasDescription{
    case Admin = 'admin';
    case Remis = 'remis';
    case Proponent = 'proponent';
    case PlanningOfficer = 'planningofficer';
    case BudgetOfficer = 'budgetofficer';
    case ResearchDirector = 'researchdirector';
    case ExtensionDirector = 'extensiondirector';
    case AccountingOfficer = 'accountingofficer';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return match ($this)
        {
            self::Admin => 'Admin',
            self::Remis => 'REMIS',
            self::Proponent => 'Proponent',
            self::PlanningOfficer => 'Planning Officer',
            self::BudgetOfficer => 'Budget Officer',
            self::ResearchDirector => 'Research Director',
            self::ExtensionDirector => 'Extension Director',
            self::AccountingOfficer => 'Accounting Officer',
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
