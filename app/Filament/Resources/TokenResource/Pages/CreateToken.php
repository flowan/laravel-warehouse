<?php

namespace App\Filament\Resources\TokenResource\Pages;

use App\Filament\Resources\TokenResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CreateToken extends CreateRecord
{
    protected static string $resource = TokenResource::class;

    protected string $plainTextToken;

    protected function handleRecordCreation(array $data): Model
    {
        $user = User::find($data['tokenable']);

        $expiresAt = $data['expires_at'] ? Carbon::make($data['expires_at']) : null;

        $token = $user->createToken($data['name'], ['*'], $expiresAt);

        $this->plainTextToken = $token->plainTextToken;

        return $token->accessToken;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->persistent()
            ->title('Token Created')
            ->body('Make sure to save the token somewhere safe. You won\'t be able to see it again. Token: '.$this->plainTextToken);
    }
}
