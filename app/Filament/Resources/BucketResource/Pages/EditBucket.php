<?php

namespace App\Filament\Resources\BucketResource\Pages;

use App\Filament\Resources\BucketResource;
use App\Helpers\BucketHelper;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBucket extends EditRecord
{
    protected static string $resource = BucketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->before(function ($record) {
                try {
                    BucketHelper::delete($record->name);
                } catch (\Exception $e) {
                    Notification::make()
                        ->warning()
                        ->title('Failed to delete bucket')
                        ->body($e->getMessage())
                        ->send();

                    $this->halt();
                }
            }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try {
            if ($data['name'] !== $record->name) {
                BucketHelper::rename($record->name, $data['name'], $data['visibility']);
            } elseif ($data['visibility'] !== $record->visibility) {
                BucketHelper::visibility($data['name'], $data['visibility']);
            }
        } catch (\Exception $e) {
            Notification::make()
                ->warning()
                ->title('Failed to update bucket')
                ->body($e->getMessage())
                ->send();

            $this->halt();
        }

        return parent::handleRecordUpdate($record, $data);
    }
}
