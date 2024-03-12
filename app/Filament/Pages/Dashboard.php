<?php

namespace App\Filament\Pages;

use Widgets\AccountWidget;
use Widgets\FilamentInfoWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';


    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
        ];
    }
}
