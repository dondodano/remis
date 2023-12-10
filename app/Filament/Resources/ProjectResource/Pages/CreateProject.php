<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use Filament\Actions;
use App\Models\Project;
use App\Models\ProjectAttachment;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProjectResource;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected static string $modelId;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Project saved')
            ->body('The project has been created successfully.');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $project = static::getModel()::create($data);
        $projectAttachment = ProjectAttachment::where('project_id', $project->id);

        $files = $data['attachments'];

        if(count($files) > $projectAttachment->count())
        {
            //update & insert
            foreach($files as $file)
            {
                ProjectAttachment::updateOrCreate([
                        'file_path' => $file,
                        'project_id' => $project->id
                    ]);
            }
        }
        return $project;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
}
