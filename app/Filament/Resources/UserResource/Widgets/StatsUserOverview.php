<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\UserResource\Pages\ListUsers;

class StatsUserOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListUsers::class;
    }

    protected function getStats(): array
    {
        // dd(
        //     $this->getPageTableQuery()->with(['roles' => function($withRoles){
        //             $withRoles->with(['assignment' => function($withAssignment){
        //                 $withAssignment->where('role_nice', 'proponent');
        //             }]);
        //         }])->get()->toArray()
        // );

        $query = $this->getPageTableQuery();

        return [
            Stat::make('Record Total',  $query->count())
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Proponents',  '1')
                ->chart([17, 2, 10, 3, 15, 4, 7])
                ->color('success'),
            Stat::make('Table Record',  $this->getPageTableRecords()->count())
                ->chart([17, 2, 10, 3, 15, 4, 7])
                ->color('success'),
        ];
    }
}
