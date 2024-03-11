<?php

namespace App\Filament\Pages;

use Illuminate\Support\Number;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use App\Models\SpatieBackup;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Artisan;
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

    public function getDefaultFileName(): ?string
    {
        return 'backup-'. Carbon::now()->format('Y-m-d-H-i-s.\z\i\p');
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
                DeleteAction::make()->label('')->color('gray')->icon('heroicon-o-trash')->tooltip('Delete')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('User deleted')
                            ->body("The user has been deleted successfully."),
                    ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Action::make('createBackup')
                    ->label('Create backup')
                    ->icon('heroicon-m-plus')
                    ->action(function(): void
                    {
                        $path =  "/storage/REMIS/";
                        $fullPath =  public_path() . $path  . $this->getDefaultFileName();
                        Artisan::call('backup:run --only-db');
                        $size = Number::fileSize(filesize($fullPath));

                        SpatieBackup::firstOrCreate([
                            'file_location' =>  $path,
                            'file_name' => $this->getDefaultFileName(),
                            'file_size' => $size
                        ]);

                        

                        Notification::make()
                            ->title("Backup created! backup-" .  $this->getDefaultFileName() )
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
