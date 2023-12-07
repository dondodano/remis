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
        $user = User::query();

        return [
            Stat::make('Record Total',  $this->getPageTableQuery()->count())
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Users', $user->whereNot('user_role', 'admin')->whereNot('user_role', 'super')->count())
                ->chart([17, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Proponents',  $user->where('user_role', 'proponent')->count())
                ->chart([17, 2, 10, 3, 15, 4, 7])
                ->color('success'),
        ];
    }
}
