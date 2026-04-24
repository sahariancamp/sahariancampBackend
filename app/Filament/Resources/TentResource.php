<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TentResource\Pages;
use App\Models\Tent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TentResource extends Resource
{
    protected static ?string $model = Tent::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tent Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->unique(Tent::class, 'slug', ignoreRecord: true),
                        Forms\Components\Select::make('type')
                            ->options([
                                'luxury' => 'Luxury',
                                'family' => 'Family',
                                'standard' => 'Standard',
                                'suite' => 'Suite',
                            ])
                            ->default('luxury')
                            ->required(),
                        Forms\Components\TextInput::make('price_per_night')
                            ->label('Regular Price ($)')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                        Forms\Components\TextInput::make('agency_price')
                            ->label('Agency Price ($)')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('capacity')
                            ->numeric()
                            ->default(2)
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                        Forms\Components\TagsInput::make('features')
                            ->placeholder('Add a feature (e.g. AC, Wifi)')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image_temp')
                            ->label('Image')
                            ->image()
                            ->disk('failover') // Use the smart failover disk
                            ->directory('tents')
                            ->visibility('public')
                            ->dehydrated(true)
                            ->afterStateHydrated(function (Forms\Components\FileUpload $component, $record) {
                                if ($record?->file) {
                                    $component->state([$record->file->path]);
                                }
                            }),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file.path')
                    ->disk('failover') // Display from the smart disk
                    ->label('Image')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\TextColumn::make('price_per_night')
                            ->label('Regular Price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('agency_price')
                            ->label('Agency Price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ListTents::route('/'),
            'create' => Pages\CreateTent::route('/create'),
            'edit' => Pages\EditTent::route('/{record}/edit'),
        ];
    }
}
