<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Tables\Concerns\InteractsWithTable;

class Activities extends Page  implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static string $view = 'filament.pages.activities';

    public function getHeading(): string | Htmlable
    {
        return 'Activity Log';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Activity::query())
            ->columns([
                TextColumn::make('log_name')
                    ->label('Log Name')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('causer_id')
                    ->label('User')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Date Modified')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([

            ])
            ->actions([

            ])
            ->bulkActions([

            ])
            ->selectCurrentPageOnly()
            ->headerActions([

            ])
            ->emptyStateIcon('heroicon-o-x-circle')
            ->emptyStateHeading('No activity log recorded yet')
            ->emptyStateDescription('Once activity los is created, it will appear here.')
            ->deferLoading();

    }
}
