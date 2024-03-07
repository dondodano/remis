<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FilesStatOverview extends BaseWidget
{
    protected function getStats(): array
    {

        return [
            Stat::make('Documents', '1')
                ->icon('heroicon-m-document-text'),
            Stat::make('PDFs', '1')
                ->icon('heroicon-m-document'),
            Stat::make('Spreadsheets', '1')
                ->icon('heroicon-m-document-chart-bar'),
            Stat::make('Images', '1')
                ->icon('heroicon-m-photo'),
        ];
    }
}
