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
use Actions\DeleteAction;
use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $nameWithSpace = $data['first_name'].' '.$data['last_name'];
        $nameWithPlus = str_replace(' ', '+', $nameWithSpace);


        $data +=  [
            'avatar' => 'https://ui-avatars.com/api/?background=random&size=128&rounded=true&bold=true&format=svg&name='.$nameWithPlus
        ];
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User saved')
            ->body('The user has been created successfully.');
    }
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
}
