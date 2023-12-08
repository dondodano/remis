<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use App\Filament\Resources\ProjectResource;

class UploadProjectAttachment extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.project-resource.pages.upload-project-attachment';

    public function mount(): void
    {
        static::authorizeResourceAccess();
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Attachment saved')
            ->body('The project attachment has been created successfully.');
    }
}
