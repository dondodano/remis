<?php

namespace App\Filament\Resources\ProjectResource\Pages;

<<<<<<< HEAD
use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
=======
use Filament\Actions;
use App\Models\ProjectAttachment;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProjectResource;
>>>>>>> 48871c4 (REMIS update on 12-07-2023)

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
<<<<<<< HEAD
=======

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $project = static::getModel()::create($data);

        if(!is_null($data['attachments']))
        {
            foreach($data['attachments'] as $attachment)
            {
                ProjectAttachment::create([
                    'file_path' => $attachment,
                    'project_id' => $project->id
                ]);
            }
        }

        return $project;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Project saved')
            ->body('The project has been created successfully.');
    }
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
}
