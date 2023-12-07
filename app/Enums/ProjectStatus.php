<?php
namespace App\Enums;

use Filament\Notifications\Notification;
use Filament\Support\Contracts\HasLabel;

enum ProjectStatus: string implements HasLabel{
    case Pending = 'pending';
    case Endoresed = 'endoresed';
    case Submitted = 'submitted';
    case Returned = 'returned';
    case Completed = 'completed';
    case UnderEvaluation = 'underevaluation';

    public function getLabel(): ?string
    {
        return match ($this)
        {
            self::Pending => 'Pending',
            self::Endoresed => 'Endoresed',
            self::Submitted => 'Submitted',
            self::Returned => 'Returned',
            self::Completed => 'Completed',
            self::UnderEvaluation => 'Under Evaluation',
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
