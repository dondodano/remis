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
            Stat::make('Record Total',  $this->getPageTableQuery()->count()),
            Stat::make('Endorsed', $project->whereNot('project_status', 'endorsed')->count()),
            Stat::make('Pending',  $project->where('project_status', 'pending')->count()),
            Stat::make('Under Evaluation',  $project->where('project_status', 'underevaluation')->count()),
            Stat::make('On Going',  $project->where('project_status', 'ongoing')->count()),
            Stat::make('Completed',  $project->where('project_status', 'completed')->count()),
        ];
    }
}
