<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Storage extends Page
{
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Drive';

    protected static ?string $navigationIcon = 'heroicon-o-cloud';

    protected static string $view = 'filament.pages.storage';
}
