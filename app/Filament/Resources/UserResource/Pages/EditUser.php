<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Validation\Rules\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('change_password')

                // ->icon('heroicon-m-user')
                // ->color('info')
                // ->requiresConfirmation()

                ->form([

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required()
                        ->rule(Password::default()),


                    Forms\Components\TextInput::make('password_confirmation')
                        ->password()
                        ->same('password')
                        ->rule(Password::default())

                ])
                ->action(function (User $record, array $data) {
                    $record->update([
                        'password' => bcrypt($data['password'])
                    ]);

                    Notification::make()
                        ->title('Password successfully updated!')
                        ->success()
                        ->send();
                })
        ];
    }
}
