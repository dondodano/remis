<?php

namespace App\Filament\Resources\ProjectResource\Pages;

<<<<<<< HEAD
use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
=======
use Filament\Actions;
use App\Models\ProjectAttachment;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ProjectResource;
>>>>>>> 48871c4 (REMIS update on 12-07-2023)

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
<<<<<<< HEAD
=======

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
}
