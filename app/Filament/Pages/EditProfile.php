<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms\Concerns\InteractsWithForms;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.edit-profile';
    protected static bool $shouldRegisterNavigation = false;

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm',
        ];
    }

    public function editProfileForm(Form $form): Form
    {
        return  $form->schema([
            Section::make('Profile Information')
                ->description('Update your account\'s profile information and email address.')
                ->schema([
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                ]),
            ])
            ->model($this->getUser())
            ->statePath('profileData');
    }

    public function editPasswordForm(Form $form): Form
    {
        return  $form->schema([
            Section::make('Update Password')
            ->description('Ensure your account is using long, random password to stay secure.')
            ->schema([
                TextInput::make('Current password')
                    ->password()
                    ->required()
                    ->currentPassword(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->rule(Password::min(4))
                    ->autocomplete('new-password')
                    ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                    ->live(debounce: 500)
                    ->same('passwordConfirmation'),
                TextInput::make('passwordConfirmation')
                    ->password()
                    ->required()
                    ->dehydrated(false),
                ]),
            ])
            ->model($this->getUser())
            ->statePath('passwordData');
    }

    protected function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();
        if (! $user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }
        return $user;
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();
        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                //->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->label('Update Profile')
                ->submit('editProfileForm'),
        ];
    }
    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updatePasswordAction')
                //->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->label('Update Password')
                ->submit('editPasswordForm'),
        ];
    }

    public function updateProfile(): void
    {
        $data = $this->editProfileForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        $this->sendSuccessNotification('Profile updated!', 'You have successfully updated your profile.');
    }
    public function updatePassword(): void
    {
        $data = $this->editPasswordForm->getState();
        $this->handleRecordUpdate($this->getUser(), $data);
        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put(['password_hash_' . Filament::getAuthGuard() => $data['password']]);
        }
        $this->editPasswordForm->fill();
        $this->sendSuccessNotification('Password updated!', 'You have successfully updated your password.');
    }
    private function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        return $record;
    }

    private function sendSuccessNotification($title, $body = null): void
    {
        Notification::make()
            ->success()
            ->title($title)
            ->body($body)
            ->send();
    }
}
