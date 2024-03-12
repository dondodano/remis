<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Number;
use Filament\Infolists\Infolist;
use Illuminate\Filesystem\Filesystem;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class Storage extends Page implements HasInfolists
{
    use InteractsWithInfolists;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Drive';

    protected static ?string $navigationIcon = 'heroicon-o-cloud';

    protected static string $view = 'filament.pages.storage';

    public $totalSpace;
    public $freeSpace;
    public $freeSpaceInPercentage;

    public function mount(): void
    {
        //static::authorizeResourceAccess();

        $local = storage_path("app");

        $this->totalSpace = disk_total_space($local);
        $this->freeSpace = disk_free_space($local);

        $this->freeSpaceInPercentage = ($this->freeSpace / $this->totalSpace) * 100;
    }


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([
                'freeSpace' => formatSizeUnits($this->freeSpace),
                'totalSpace' => formatSizeUnits($this->totalSpace),
                'totalSpaceInPercentage' => Number::percentage($this->freeSpaceInPercentage, precision: 2)
            ])
            ->schema([
                Section::make('Disk Usage')
                    ->description("The web application utilizes Web Storage, a browser-based mechanism for persisting data locally on the user's device.")
                    ->icon('heroicon-m-cloud')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('freeSpace'),
                                TextEntry::make('totalSpace'),
                                TextEntry::make('totalSpaceInPercentage'),
                            ])
                    ])
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\StorageStatOverview::class,
            \App\Filament\Widgets\StorageChart::class
        ];
    }
}
