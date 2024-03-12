<?php

namespace App\Filament\Pages;

use stdClass;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Spatie\Activitylog\Models\Activity;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
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
                Split::make([
                    ImageColumn::make('avatar')
                        ->state(
                            static function (Activity $act): string {
                                return $act->causer->avatar;
                            }
                        )
                        ->toggleable()
                        ->circular()
                        ->grow(false),

                    TextColumn::make('causer')
                        ->label('User')
                        ->formatStateUsing(function($state, User $user){
                            return $state->first_name.' '.$state->last_name;
                        })
                        ->searchable()
                        ->toggleable(),

                    TextColumn::make('role')
                        ->label('Role')
                        ->state(
                            static function (Activity $act, User $user): string {
                                return (string)($act->causer->user_role->getLabel());
                            }
                        )
                        ->badge('info')
                        ->searchable()
                        ->toggleable(),


                    TextColumn::make('description')
                        ->label('Description')
                        ->searchable()
                        ->toggleable()
                        ->sortable(),

                    TextColumn::make('updated_at')
                        ->icon('heroicon-m-calendar')
                        ->label('Date Modified')
                        //->badge()
                        ->color('gray')
                        ->searchable()
                        ->toggleable()
                        ->sortable(),

                    TextColumn::make('created_at')
                        ->icon('heroicon-m-clock')
                        ->label('Date Created')
                        //->badge()
                        ->color('gray')
                        ->since()
                        ->toggleable()
                        ->sortable(),
                ]),
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
