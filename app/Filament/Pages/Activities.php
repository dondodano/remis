<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Activities extends Page
{
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static string $view = 'filament.pages.activities';
}
