<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Number;
use Filament\Infolists\Infolist;
use Illuminate\Filesystem\Filesystem;
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

    public function mount(): void
    {
        //static::authorizeResourceAccess();

        $local = storage_path("app");

        $this->totalSpace = formatSizeUnits(disk_total_space($local));
        $this->freeSpace = formatSizeUnits(disk_free_space($local));
    }


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([
                'freeSpace' => $this->freeSpace,
                'totalSpace' => $this->totalSpace
            ])
            ->schema([
                TextEntry::make('freeSpace'),
                TextEntry::make('totalSpace'),
            ]);
    }
}
