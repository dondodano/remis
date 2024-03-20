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
            Actions\CreateAction::make()
                ->label('Create New User')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->modifyQueryUsing(function(Builder $query){
                    return $query->whereHas('roles', function(Builder $roleQuery){
                        $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                            //$assignmentsQuery->where('role_nice', 'proponent');
                        });
                    });
                }),
            'REMIS' => Tab::make()
                ->modifyQueryUsing(function(Builder $query){
                    return $query->whereHas('roles', function(Builder $roleQuery){
                        $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                            $assignmentsQuery->where('role_nice', 'remis');
                        });
                    });
                }),
            'Proponent' => Tab::make()
                ->modifyQueryUsing(function(Builder $query){
                    return $query->whereHas('roles', function(Builder $roleQuery){
                        $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                            $assignmentsQuery->where('role_nice', 'proponent');
                        });
                    });
                }),
            'R&D Dir.' => Tab::make()
                ->modifyQueryUsing(function(Builder $query){
                    return $query->whereHas('roles', function(Builder $roleQuery){
                        $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                            $assignmentsQuery->where('role_nice', 'research director');
                        });
                    });
                }),
            'Ext. Dir.' => Tab::make()
                ->modifyQueryUsing(function(Builder $query){
                    return $query->whereHas('roles', function(Builder $roleQuery){
                        $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                            $assignmentsQuery->where('role_nice', 'extension director');
                        });
                    });
                }),
            'Budget Offr.' => Tab::make()
                ->modifyQueryUsing(function(Builder $query){
                    return $query->whereHas('roles', function(Builder $roleQuery){
                        $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                            $assignmentsQuery->where('role_nice', 'budget officer');
                        });
                    });
                }),
            'Plan. Offr.' => Tab::make()
                ->modifyQueryUsing(function(Builder $query){
                    return $query->whereHas('roles', function(Builder $roleQuery){
                        $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                            $assignmentsQuery->where('role_nice', 'planning officer');
                        });
                    });
                }),
            'Acc. Offr.' => Tab::make()
                ->modifyQueryUsing(function(Builder $query){
                    return $query->whereHas('roles', function(Builder $roleQuery){
                        $roleQuery->whereHas('assignment', function(Builder $assignmentsQuery){
                            $assignmentsQuery->where('role_nice', 'accounting officer');
                        });
                    });
                }),
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
