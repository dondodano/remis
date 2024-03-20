<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Enums\UserRole;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListUsers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            // 'All' => Tab::make()
            //     ->modifyQueryUsing(function(Builder $query){
            //         $data = $query->with(['roles' => function($withRoles){
            //             $withRoles->with(['assignment' => function($withAssignment){
            //                 $withAssignment->whereNot('role_nice', 'admin');
            //             }]);
            //         }]);

            //         return $data;
            //     }),
            // 'REMIS' => Tab::make()
            //     ->modifyQueryUsing(function(Builder $query){
            //         return $query->with(['roles' => function($withRoles){
            //             $withRoles->with(['assignment' => function($withAssignment){
            //                 $withAssignment->where('role_nice', 'remis');
            //             }]);
            //         }]);
            //     }),
            // 'Proponent' => Tab::make()
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('user_role' , 'proponent')),
            // 'RIDE Director' => Tab::make()
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('user_role' , 'ridedirector')),
            // 'RIDE Staff' => Tab::make()
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('user_role' , 'ridestaff')),
            // 'Budget Officer' => Tab::make()
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('user_role' , 'budgetofficer')),
            // 'Planning Officer' => Tab::make()
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('user_role' , 'planningofficer')),
            // 'Accounting Officer' => Tab::make()
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('user_role' , 'accountingofficer')),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'All';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UserResource\Widgets\StatsUserOverview::class,
        ];
    }
}
