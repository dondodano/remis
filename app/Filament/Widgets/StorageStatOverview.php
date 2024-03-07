<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StorageStatOverview extends BaseWidget
{

    protected static ?string $pollingInterval = null;

    public $totalSpace;
    public $freeSpace;
    public $freeSpaceInPercentage;
    public $differenceInSpace;

    public function mount(): void
    {
        //static::authorizeResourceAccess();

    }

    protected function getStats(): array
    {
        $local = storage_path("app");

        $this->totalSpace = disk_total_space($local);
        $this->freeSpace = disk_free_space($local);

        $this->freeSpaceInPercentage = ($this->freeSpace / $this->totalSpace) * 100;
        $this->differenceInSpace = formatSizeUnits($this->totalSpace - $this->freeSpace);

        $statFreeSpace = Stat::make('Free Space', formatSizeUnits($this->freeSpace));

        $statTotalSpace =  Stat::make('Total Space', formatSizeUnits($this->totalSpace))
            ->description('Disk space')
            ->descriptionIcon('heroicon-m-server')
            ->color('success');

        $statFreeSpaceInPercentage = Stat::make('Free Space in Percentage', Number::percentage($this->freeSpaceInPercentage, precision: 2));

        $statFreeSpace->description($this->differenceInSpace .' increate')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('danger');

        $statFreeSpaceInPercentage->description(' increase')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('danger');

        if($this->freeSpaceInPercentage > 74)
        {
            $statFreeSpace->description($this->differenceInSpace .' decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success');

            $statFreeSpaceInPercentage->description(' decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success');
        }


        return [
            $statFreeSpace,
            $statTotalSpace,
            $statFreeSpaceInPercentage
        ];
    }
}
