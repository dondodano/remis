<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Actions\DeleteAction;
use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

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
}
