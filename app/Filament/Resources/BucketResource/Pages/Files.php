<?php

namespace App\Filament\Resources\BucketResource\Pages;

use App\Filament\Resources\BucketResource;
use Filament\Resources\Pages\Page;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Files extends Page
{
    protected static string $resource = BucketResource::class;

    protected static string $view = 'filament.resources.bucket-resource.pages.files';

    protected ?Model $record = null;

    public array $directories = [];

    public array $files = [];

    public array $breadcrumbs = [];

    public string $path = '';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->path = (string) request()->input('path', '');

        if (Str::of($this->path)->contains('..')) {
            abort(403);
        }

        $parentPath = dirname($this->path);
        if ($parentPath === '.') {
            $parentPath = '';
        }

        if (! empty($this->path)) {
            $this->breadcrumbs = collect(explode('/', $this->path))->map(function ($part, $index) {
                return (object) [
                    'name' => $part,
                    'path' => implode('/', array_slice(explode('/', $this->path), 0, $index + 1)),
                ];
            })->toArray();
        }

        $directories = Storage::directories(bucket_relative_path($this->record->name.'/'.$this->path));

        foreach ($directories as $key => $directory) {
            $directories[$key] = (object) [
                'name' => basename($directory),
                'path' => Str::of($directory)->after(bucket_relative_path($this->record->name))->trim('/')->__toString(),
            ];
        }

        $this->directories = array_merge([(object) ['name' => '..', 'path' => $parentPath]], $directories);

        $files = Storage::files(bucket_relative_path($this->record->name.'/'.$this->path));

        foreach ($files as $key => $file) {
            $files[$key] = (object) [
                'name' => basename($file),
                'path' => Str::of($file)->after(bucket_relative_path($this->record->name))->trim('/')->__toString(),
                'url' => url($file),
                'size' => format_filesize(Storage::size($file), 2),
                'last_modified' => Carbon::createFromTimestamp(Storage::lastModified($file))->format(Table::$defaultDateTimeDisplayFormat),
            ];
        }

        $this->files = $files;
    }

    protected function resolveRecord(int|string $key): Model
    {
        $record = static::getResource()::resolveRecordRouteBinding($key);

        if ($record === null) {
            throw (new ModelNotFoundException())->setModel($this->getModel(), [$key]);
        }

        return $record;
    }

    public function getRecord(): Model
    {
        return $this->record;
    }
}
