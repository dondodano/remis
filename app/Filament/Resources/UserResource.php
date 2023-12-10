<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Enums\UserRole;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Tables\Actions\CreateAction;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'System';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User information')
                    ->description('Please enter your personal information in the fields below. ')
                    ->icon('heroicon-m-identification')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'sm' => 1,
                            'md' => 1,
                            'lg' => 2,
                            'xl' => 2,
                            '2xl' => 6,
                        ])
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('First Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, Closure $fail) {
                                        if (($email = filter_var($value, FILTER_VALIDATE_EMAIL)) !== false) {
                                            $institutionalEmail = explode('@', $email);
                                            if ($institutionalEmail[1] != config('app.email_domain')) {
                                                $fail('Email used in not from the institution. Try using your institutional email instead.');
                                            }
                                        }
                                    };
                                },
                            ])
                            ->hint('Use your institutional email')
                            ->hintIcon('heroicon-m-information-circle')
                            ->helperText("Provide a valid email address where we can reach you. We'll use this for account-related communication")
                            ->required()
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('Password')
                            ->formatStateUsing(function($state, User $user){
                                return '1234';
                            })
                            ->hint('Alphanumeric')
                            ->hintIcon('heroicon-m-information-circle')
                            ->helperText("Choose a strong password with a mix of uppercase and lowercase letters, numbers, and special characters.")
                            ->required()
                            ->password()
                            ->maxLength(255),
                        Select::make('user_role')
                            ->label('Role')
                            ->helperText("Select your role from the options to provide access to the features most relevant to the user.")
                            ->options(function($state){
                                return UserRole::specificValues([
                                    'super',
                                ]);
                            })
                        ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar'),
                TextColumn::make('first_name')
                    ->formatStateUsing(function($state, User $user){
                        return $user->first_name .' '. $user->last_name;
                    })
                    ->label('Name')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('user_role')
                    ->label('Role')
                    ->badge()
                    ->color(Color::Blue)
                    ->toggleable()
                    ->searchable(),
                IconColumn::make('email_verified_at')
                    ->label('Verified?')
                    ->toggleable()
                    ->getStateUsing(fn ($record): bool => $record->email_verified_at !== null)
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-shield-exclamation')
                    ->size(IconColumn\IconColumnSize::Medium)
            ])
            ->filters([
                TrashedFilter::make(),
                TernaryFilter::make('email_verified_at')
                    ->label('Email verification')
                    ->nullable()
                    ->placeholder('All users')
                    ->trueLabel('Verified users')
                    ->falseLabel('Not verified users')
                    ->queries(
                        true : fn (Builder $query) => $query->whereNotNull('email_verified_at'),
                        false : fn (Builder $query) => $query->whereNull('email_verified_at')
                    )
            ])
            ->actions([
                // Action : Send Credential
                Tables\Actions\Action::make('send-credential')
                    ->label('')
                    ->icon('heroicon-o-paper-airplane')
                    ->action(function(User $user): void{
                        Notification::make()
                            ->title("Sending credential to " . $user->email)
                            ->icon('heroicon-o-paper-airplane')
                            ->success()
                            ->duration(2000)
                            ->send();
                    })->color('gray')->tooltip('Send credentials to email')
                    ->hidden(fn ($record) => !is_null($record->deleted_at)),

                // Action : Edit User on Modal
                Tables\Actions\EditAction::make()
                    ->label('')->color('gray')->tooltip('Edit user')
                    //methods below can be executed when edit is on modal
                    ->mutateFormDataUsing(function (array $data): array {
                        $nameWithSpace = $data['first_name'].' '.$data['last_name'];
                        $nameWithPlus = str_replace(' ', '+', $nameWithSpace);
                        $data['avatar'] = 'https://ui-avatars.com/api/?background=random&size=128&rounded=true&bold=true&format=svg&name='.$nameWithPlus;

                        return $data;
                    })->successNotification(
                        Notification::make()
                            ->success()
                            ->title('User updated')
                            ->body('The user has been saved successfully.'),
                    )->hidden(fn ($record) => !is_null($record->deleted_at)),

                // Action : Restore
                Tables\Actions\RestoreAction::make()->label('')->color('gray')
                    ->tooltip('Restore user'),

                // Action Group : of Delete , Approve and Disapprove User
                ActionGroup::make([
                    Tables\Actions\DeleteAction::make()->label('Delete')->color('gray'),


                    Tables\Actions\Action::make('disprove-verification')
                        ->label('Disprove Verification')
                        ->icon('heroicon-o-shield-exclamation')
                        ->action(function(User $user): void{

                            if(!is_null($user->email_verified_at))
                            {
                                $user->email_verified_at = null;
                                $user->update();
                            }

                            Notification::make()
                                ->title("Action disprove verification of " . $user->name)
                                ->success()
                                ->duration(2000)
                                ->send();
                        })->hidden(fn ($record) => is_null($record->email_verified_at) || !is_null($record->deleted_at)),
                    Tables\Actions\Action::make('approve-verification')
                        ->label('Approve Verification')
                        ->icon('heroicon-o-shield-check')
                        ->action(function(User $user): void{

                            if(is_null($user->email_verified_at))
                            {
                                $user->email_verified_at = now()->format('Y-m-d H:i:s');
                                $user->update();
                            }

                            Notification::make()
                                ->title("Action approve verification of " . $user->name)
                                ->success()
                                ->duration(2000)
                                ->send();
                        })->hidden(fn ($record) => (!is_null($record->email_verified_at) || !is_null($record->deleted_at))),
                ])
                    ->label('')
                    ->tooltip('More actions...')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add new user')
                    ->icon('heroicon-m-plus'),
            ])
            ->emptyStateDescription('Once you add new user, it will appear here.');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            //'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

}
