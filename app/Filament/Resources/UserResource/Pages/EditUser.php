<?php

namespace App\Filament\Resources\UserResource\Pages;

<<<<<<< HEAD
<<<<<<< HEAD
use App\Filament\Resources\UserResource;
use Filament\Actions;
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
use Filament\Actions;
use Filament\Pages\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }


<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
}
