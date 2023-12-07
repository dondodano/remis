<?php
namespace App\Enums;

use Filament\Notifications\Notification;
use Filament\Support\Contracts\HasLabel;

enum ExtensionSubCategory: string implements HasLabel{
    case Formal = 'formal';
    case Informal = 'informal';
    case CommunityBased = 'communitybased';

    public function getLabel(): ?string
    {
        return match ($this)
        {
            self::Formal => 'Formal',
            self::Informal => 'Informal',
            self::CommunityBased => 'Community Based',
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
