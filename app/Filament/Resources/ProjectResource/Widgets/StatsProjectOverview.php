<?php

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\ProjectResource\Pages\ListProjects;

class StatsProjectOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListProjects::class;
    }

    protected function getStats(): array
    {
        $project = Project::query();

        return [
            Stat::make('Record Total',  $this->getPageTableQuery()->count())
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Endorsed', $project->whereNot('project_status', 'endorsed')->count())
                ->chart([17, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Pending',  $project->where('project_status', 'pending')->count())
                ->chart([17, 2, 10, 3, 15, 4, 7])
                ->color('success'),
            Stat::make('Under Evaluation',  $project->where('project_status', 'underevaluation')->count())
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
            Stat::make('On Going',  $project->where('project_status', 'ongoing')->count())
                ->chart([17, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
            Stat::make('Completed',  $project->where('project_status', 'completed')->count())
                ->chart([17, 2, 10, 3, 15, 4, 7])
                ->color('primary'),
        ];
    }
}
