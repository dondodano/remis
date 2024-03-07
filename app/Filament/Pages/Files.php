<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Widgets\FilesStatOverview;
use Filament\Tables\Concerns\InteractsWithTable;

class Files extends Page implements HasTable
{
    //use InteractsWithInfolists;
    use InteractsWithTable;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Drive';

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static string $view = 'filament.pages.files';

    protected function getHeaderWidgets(): array
    {
        return [
            FilesStatOverview::class
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                TextColumn::make('file_name')
                    ->limit(15)
                    ->label('File Name')
                    //->searchable()
                    ->sortable()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    }),
                ImageColumn::make('avatar')
                    ->size(30)
                    ->toggleable(),
                TextColumn::make('first_name')
                    ->formatStateUsing(function($state, User $user){
                        return $user->first_name .' '. $user->last_name;
                    })
                    ->label('Name')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Date modified')
                    ->toggleable()
                    ->since()
                    ->toggleable()
            ])
            ->filters([

            ])
            ->actions([
                Action::make('view')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->label("")
                    ->color('gray')
                    ->action(function(User $user): void{
                        Notification::make()
                            ->title("Action disprove verification of " . $user->name)
                            ->success()
                            ->duration(2000)
                            ->send();
                    })
            ])
            ->bulkActions([

            ])
            ->emptyStateIcon('heroicon-o-x-circle')
            ->emptyStateHeading('No file uploaded yet')
            ->emptyStateDescription('Once you file uploaded, it will appear here.');
    }
}
