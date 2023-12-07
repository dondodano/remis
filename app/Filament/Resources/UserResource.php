<?php

namespace App\Filament\Resources;

<<<<<<< HEAD
<<<<<<< HEAD
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Enums\UserRole;
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
<<<<<<< HEAD
<<<<<<< HEAD
use Filament\Tables\Filters\Filter;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
<<<<<<< HEAD
<<<<<<< HEAD
=======
use Filament\Actions\CreateAction;

>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
use Filament\Actions\CreateAction;

>>>>>>> 48871c4 (REMIS update on 12-07-2023)

class UserResource extends Resource
{
    protected static ?string $model = User::class;

<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'System';

<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
<<<<<<< HEAD
<<<<<<< HEAD
                //
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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


<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
<<<<<<< HEAD
<<<<<<< HEAD
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
                    ->sortable(),
                TextColumn::make('user_role')
                    ->label('Role')
                    ->badge()
                    ->color(Color::Blue)
<<<<<<< HEAD
<<<<<<< HEAD
                    ->searchable(),
                IconColumn::make('email_verified_at')
                    ->label('Verified?')
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
                    ->toggleable()
                    ->searchable(),
                IconColumn::make('email_verified_at')
                    ->label('Verified?')
                    ->toggleable()
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
                // Action : Send Credential
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
                // Action : Send Credential
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
                Tables\Actions\Action::make('send-credential')
                    ->label('')
                    ->icon('heroicon-o-paper-airplane')
                    ->action(function(User $user): void{
                        Notification::make()
                            ->title("Sending credential to " . $user->email)
<<<<<<< HEAD
<<<<<<< HEAD
=======
                            ->icon('heroicon-o-paper-airplane')
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
                            ->icon('heroicon-o-paper-airplane')
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
                            ->success()
                            ->duration(2000)
                            ->send();
                    })->color('gray')->tooltip('Send credentials to email'),

<<<<<<< HEAD
<<<<<<< HEAD
                Tables\Actions\EditAction::make()->label('')->color('gray')->tooltip('Edit user'),

=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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
                    ),

                // Action Group : of Delete , Approve and Disapprove User
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
                ActionGroup::make([
                    Tables\Actions\DeleteAction::make()->label('Delete')->color('gray'),
                    Tables\Actions\RestoreAction::make()->label('Restore')->color('gray'),

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
<<<<<<< HEAD
<<<<<<< HEAD
                Tables\Actions\CreateAction::make(),
            ]);
=======
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
                Tables\Actions\CreateAction::make()
                    ->label('Add new user')
                    ->icon('heroicon-m-plus'),
            ])
            ->emptyStateDescription('Once you add new user, it will appear here.');
<<<<<<< HEAD
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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
<<<<<<< HEAD
<<<<<<< HEAD
            'edit' => Pages\EditUser::route('/{record}/edit'),
=======
            //'edit' => Pages\EditUser::route('/{record}/edit'),
>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======
            //'edit' => Pages\EditUser::route('/{record}/edit'),
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
<<<<<<< HEAD
<<<<<<< HEAD
=======

>>>>>>> b6240d91eae0fa86540454de2c93ee7643754ce3
=======

>>>>>>> 48871c4 (REMIS update on 12-07-2023)
}
