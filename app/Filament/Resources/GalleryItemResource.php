<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages;
use App\Models\GalleryItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title'),
                Forms\Components\Select::make('category')
                    ->options([
                        'Sanctuaries' => 'Sanctuaries',
                        'Experiences' => 'Experiences',
                        'Camp Life' => 'Camp Life',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('image_temp')
                    ->label('Image')
                    ->image()
                    ->disk('failover')
                    ->directory('gallery')
                    ->visibility('public')
                    ->required(fn ($record) => !$record?->file_id)
                    ->dehydrated(true)
                    ->afterStateHydrated(function (Forms\Components\FileUpload $component, $record) {
                        if ($record?->file) {
                            $component->state([$record->file->path]);
                        }
                    }),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file.path')
                    ->disk('failover')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('category')->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryItems::route('/'),
            'create' => Pages\CreateGalleryItem::route('/create'),
            'edit' => Pages\EditGalleryItem::route('/{record}/edit'),
        ];
    }
}
