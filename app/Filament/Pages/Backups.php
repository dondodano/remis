<?php

namespace App\Filament\Pages;

use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\SpatieBackup;
use Illuminate\Support\Number;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Spatie\Backup\BackupDestination\BackupDestination;

class Backups extends Page  implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static string $view = 'filament.pages.backups';

    public function getHeading(): string | Htmlable
    {
        return 'Backups';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'System';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(SpatieBackup::query())
            ->columns([
                TextColumn::make('file_name')
                    ->label('Filename')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('file_size')
                    ->label('Size')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Action::make('delete')
                    ->label('')
                    ->color('gray')
                    ->icon('heroicon-o-trash')
                    ->tooltip('Delete')
                    ->action(function(SpatieBackup $record){

                            Notification::make()
                                ->title("Backup created! " .  $record->file_name )
                                ->success()
                                ->duration(2000)
                                ->send();

                            $record->delete();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Delete backup')
                    ->modalDescription('Are you sure you\'d like to delete this backup? This cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete it')
                    ->hidden(function(SpatieBackup $record){
                        return !is_null($record->deleted_at);
                    }),

                Action::make('forceDelete')
                    ->label('')
                    ->color('gray')
                    ->icon('heroicon-o-trash')
                    ->tooltip('Force Delete')
                    ->action(function(SpatieBackup $record){

                        $fileStoragePath = 'public/REMIS/' . $record->file_name;

                        Storage::delete( $fileStoragePath);

                        Notification::make()
                            ->title("Backup deleted! " . $record->file_name)
                            ->success()
                            ->duration(2000)
                            ->send();

                        $record->forceDelete();

                    })
                    ->requiresConfirmation()
                    ->modalHeading('Delete backup')
                    ->modalDescription('Are you sure you\'d like to force delete this backup? This cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete it')
                    ->hidden(function(SpatieBackup $record){
                        return is_null($record->deleted_at);
                    }),
                Action::make('restore')
                    ->label('')
                    ->color('gray')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->tooltip('Restore')
                    ->action(function(SpatieBackup $record){

                        Notification::make()
                            ->title("Backup restored! " . $record->file_name)
                            ->success()
                            ->duration(2000)
                            ->send();

                        $record->restore();

                    })
                    ->requiresConfirmation()
                    ->modalHeading('Restore backup')
                    ->modalDescription('Are you sure you\'d like to restore this backup?')
                    ->modalSubmitActionLabel('Yes, restore it')
                    ->hidden(function(SpatieBackup $record){
                        return is_null($record->deleted_at);
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('bulkDelete')
                        ->label('Delete')
                        ->color('gray')
                        ->icon('heroicon-o-trash')
                        ->action(function(Collection  $records){
                                Notification::make()
                                    ->title("Backup deleted! " .  $records->each->file_name )
                                    ->success()
                                    ->duration(2000)
                                    ->send();

                                $records->each->delete();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Delete backup')
                        ->modalDescription('Are you sure you\'d like to delete this backup? This cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete it')
                        ->hidden(function(SpatieBackup $record){
                            return !is_null($record->deleted_at);
                        }),

                    BulkAction::make('bulkForceDelete')
                        ->label('Force Delete')
                        ->color('gray')
                        ->icon('heroicon-o-trash')
                        ->action(function(Collection  $records){

                            $fileStoragePath = 'public/REMIS/' . $records->each->file_name;

                            Storage::delete( $fileStoragePath);

                            Notification::make()
                                ->title("Backup deleted! " . $records->each->file_name)
                                ->success()
                                ->duration(2000)
                                ->send();

                            $records->each->forceDelete();

                        })
                        ->requiresConfirmation()
                        ->modalHeading('Delete backup')
                        ->modalDescription('Are you sure you\'d like to force delete this backup? This cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete it')
                        ->hidden(function(SpatieBackup $record){
                            return is_null($record->deleted_at);
                        }),
                    BulkAction::make('bulkRestore')
                        ->label('Restore')
                        ->color('gray')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->action(function(Collection  $records){

                            Notification::make()
                                ->title("Backup restored! " . $records->each->file_name)
                                ->success()
                                ->duration(2000)
                                ->send();

                            $records->each->restore();

                        })
                        ->requiresConfirmation()
                        ->modalHeading('Restore backup')
                        ->modalDescription('Are you sure you\'d like to restore this backup?')
                        ->modalSubmitActionLabel('Yes, restore it')
                        ->hidden(function(SpatieBackup $record){
                            return is_null($record->deleted_at);
                        }),
                ])
            ])
            ->headerActions([
                Action::make('createBackup')
                    ->label('Create backup')
                    ->icon('heroicon-m-plus')
                    ->action(function(): void
                    {
                        $defaultFileName = 'backup-'. Carbon::now()->format('Y-m-d-H-i-s.\z\i\p');

                        $path =  "/storage/REMIS/";
                        $fullPath =  public_path() . $path  . $defaultFileName;
                        Artisan::call('backup:run --only-db');
                        $size = Number::fileSize(filesize($fullPath));

                        SpatieBackup::firstOrCreate([
                            'file_location' =>  $path,
                            'file_name' => $defaultFileName,
                            'file_size' => $size
                        ]);



                        Notification::make()
                            ->title("Backup created! backup-" .  $defaultFileName )
                            ->success()
                            ->duration(2000)
                            ->send();
                    }),
            ])
            ->emptyStateIcon('heroicon-o-x-circle')
            ->emptyStateHeading('No backup created yet')
            ->emptyStateDescription('Once backup is created, it will appear here.');
    }

}
