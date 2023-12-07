<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProjectResource;
use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListProjects extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query),
            'Research' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('project_category' , 'research')),
            'Extension' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('project_category' , 'extension')),
            'Internal Funding' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('fund_category' , 'internal')),
            'External Funding' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('fund_category' , 'external')),

        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'All';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProjectResource\Widgets\StatsProjectOverview::class,
        ];
    }

}
