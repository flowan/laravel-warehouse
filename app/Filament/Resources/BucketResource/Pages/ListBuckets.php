<?php

namespace App\Filament\Resources\BucketResource\Pages;

use App\Filament\Resources\BucketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBuckets extends ListRecords
{
    protected static string $resource = BucketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
