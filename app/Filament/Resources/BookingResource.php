<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Section::make('Customer & Status')
                            ->schema([
                                Forms\Components\TextInput::make('booking_number')
                                    ->default('BK-' . strtoupper(\Illuminate\Support\Str::random(6)))
                                    ->required()
                                    ->disabled()
                                    ->dehydrated(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'confirmed' => 'Confirmed',
                                        'paid' => 'Paid',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->default('pending')
                                    ->required(),
                                Forms\Components\TextInput::make('customer_name')
                                    ->required(),
                                Forms\Components\TextInput::make('customer_email')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('customer_phone'),
                                Forms\Components\DatePicker::make('check_in')
                                    ->required(),
                                Forms\Components\DatePicker::make('check_out'),
                                Forms\Components\TextInput::make('total_price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),
                            ])->columnSpan(1),

                        Forms\Components\Section::make('Booking Items')
                            ->schema([
                                // Placeholder for now, will add repeater if needed or just simple notes
                                Forms\Components\Textarea::make('notes')
                                    ->rows(5),
                                Forms\Components\Placeholder::make('info')
                                    ->content('Items management can be added here with a Repeater and MorphTo relationship.')
                            ])->columnSpan(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('check_in')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'paid' => 'success',
                        'cancelled' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
