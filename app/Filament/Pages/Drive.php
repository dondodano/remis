<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Drive extends Page
{

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Files';

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static string $view = 'filament.pages.drive';
}
