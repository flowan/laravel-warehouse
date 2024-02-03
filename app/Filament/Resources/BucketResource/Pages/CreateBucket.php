<?php

namespace App\Filament\Resources\BucketResource\Pages;

use App\Filament\Resources\BucketResource;
use App\Helpers\BucketHelper;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CreateBucket extends CreateRecord
{
    protected static string $resource = BucketResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        try {
            BucketHelper::create($data['name'], $data['visibility']);
        } catch (\Exception $e) {
            Notification::make()
                ->warning()
                ->title('Failed to create bucket')
                ->body($e->getMessage())
                ->send();

            $this->halt();
        }

        return parent::handleRecordCreation($data);
    }
}
