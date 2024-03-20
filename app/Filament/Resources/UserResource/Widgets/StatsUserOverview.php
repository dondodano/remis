<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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

        $proponentCount = User::whereHas('roles', function(Builder $roleQuery){
            $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                $assignmentsQuery->where('role_nice', 'proponent');
            });
        })->count();


        $otherUserCount = User::whereHas('roles', function(Builder $roleQuery){
            $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                $assignmentsQuery->whereNot('role_nice', 'admin');
            });
        })->count();

        return [
            Stat::make('Record Total',  $this->getPageTableQuery()->count())
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Proponents',  $proponentCount)
                ->chart([17, 2, 10, 3, 15, 4, 7])
                ->color('success'),
            Stat::make('Users',  $otherUserCount)
                ->chart([17, 2, 10, 3, 15, 4, 7])
                ->color('success'),
        ];
    }
}
