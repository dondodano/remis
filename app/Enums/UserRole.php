<?php
namespace App\Enums;

<<<<<<< HEAD
<<<<<<< HEAD
=======
use Filament\Notifications\Notification;
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
use Filament\Notifications\Notification;
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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
<<<<<<< HEAD
<<<<<<< HEAD

    public function getLabel(): ?string{
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
    case Guest = 'guest';

    public function getLabel(): ?string
    {
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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
<<<<<<< HEAD
<<<<<<< HEAD
        };
    }
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
}
