<?php
namespace App\Enums;

use Filament\Notifications\Notification;
use Filament\Support\Contracts\HasLabel;

enum MemberRole: string implements HasLabel{
    case Leader = 'leader';
    case Member = 'member';

    public function getLabel(): ?string
    {
        return match ($this)
        {
            self::Leader => 'Leader',
            self::Member => 'Member',
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
