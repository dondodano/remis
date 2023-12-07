<?php
namespace App\Enums;

use Filament\Notifications\Notification;
use Filament\Support\Contracts\HasLabel;

enum ProjectStatus: string implements HasLabel{

    case Submitted = 'submitted';
    case Endorsed = 'endorsed';
    case Approved = 'approved';
    case OnGoing = 'ongoing';
    case Completed = 'completed';
    case Returned = 'returned';
    case Pending = 'pending';
    case UnderEvaluation = 'underevaluation';
    case Withdrawn = 'withdrawn';
    case Disapproved = 'disapproved';


    public function getLabel(): ?string
    {
        return match ($this)
        {
            self::Submitted => 'Submitted',
            self::Endorsed => 'Endorsed',
            self::Approved => 'Approved',
            self::OnGoing => 'On Going',
            self::Completed => 'Completed',
            self::Returned => 'Returned',
            self::Pending => 'Pending',
            self::UnderEvaluation => 'Under Evaluation',
            self::Withdrawn => 'Withdrawn',
            self::Disapproved => 'Disapproved',

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
