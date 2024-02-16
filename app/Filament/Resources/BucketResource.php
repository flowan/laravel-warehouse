<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BucketResource\Pages;
use App\Models\Bucket;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BucketResource extends Resource
{
    protected static ?string $model = Bucket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('name', 'id')) /** @phpstan-ignore-line */
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('visibility')
                    ->options([
                        'public' => 'Public',
                        'private' => 'Private',
                    ])
                    ->default('public')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('visibility')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'private' => 'warning',
                        'public' => 'success',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\Action::make('files')
                    ->label('Files')
                    ->icon('heroicon-o-folder-open')
                    ->url(fn (Bucket $record): string => route('filament.admin.resources.buckets.files', $record)),
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('id', 'desc');
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
            'index' => Pages\ListBuckets::route('/'),
            'create' => Pages\CreateBucket::route('/create'),
            'edit' => Pages\EditBucket::route('/{record}/edit'),
            'files' => Pages\Files::route('/{record}/files'),
        ];
    }
}
