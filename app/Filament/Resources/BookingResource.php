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
use Carbon\Carbon;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?int $navigationSort = 1;

    public static function updateTotalPrice(Forms\Get $get, Forms\Set $set): void
    {
        $checkIn = $get('check_in') ?? $get('../../check_in');
        $checkOut = $get('check_out') ?? $get('../../check_out');
        $items = $get('items') ?? $get('../../items') ?? [];

        $nights = 1;
        if ($checkIn && $checkOut) {
            $nights = max(1, Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut)));
        }

        $total = 0;
        foreach ($items as $item) {
            $qty = floatval($item['quantity'] ?? 0);
            $price = floatval($item['price_at_time'] ?? 0);
            $total += ($qty * $price) * $nights;
        }

        if ($get('check_in') !== null) {
            $set('total_price', $total);
        } else {
            $set('../../total_price', $total);
        }
    }

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
                                Forms\Components\Select::make('booking_type')
                                    ->options([
                                        'individual' => 'Individual',
                                        'agency' => 'Travel Agency',
                                    ])
                                    ->default('individual')
                                    ->required()
                                    ->live(),
                                Forms\Components\TextInput::make('customer_name')
                                    ->required(),
                                Forms\Components\TextInput::make('customer_email')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('customer_phone'),
                                Forms\Components\DatePicker::make('check_in')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::updateTotalPrice($get, $set)),
                                Forms\Components\DatePicker::make('check_out')
                                    ->live()
                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::updateTotalPrice($get, $set)),
                                Forms\Components\TextInput::make('total_price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required()
                                    ->readOnly(), // User requested it to be read only
                            ])->columnSpan(1),

                        Forms\Components\Section::make('Booking Details')
                            ->schema([
                                Forms\Components\Repeater::make('items')
                                    ->relationship()
                                    ->live(onBlur: true) // Update when editing stops
                                    ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::updateTotalPrice($get, $set))
                                    ->schema([
                                        Forms\Components\MorphToSelect::make('bookable')
                                            ->types([
                                                Forms\Components\MorphToSelect\Type::make(\App\Models\Tent::class)
                                                    ->titleAttribute('name'),
                                                Forms\Components\MorphToSelect\Type::make(\App\Models\Activity::class)
                                                    ->titleAttribute('name'),
                                            ])
                                            ->label('Item')
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                                $type = $get('bookable_type');
                                                $id = $get('bookable_id');
                                                $bookingType = $get('../../booking_type');
                                                
                                                if ($type && $id) {
                                                    $model = $type::find($id);
                                                    if ($model) {
                                                        if ($type === \App\Models\Tent::class) {
                                                            $price = ($bookingType === 'agency' && $model->agency_price) ? $model->agency_price : $model->price_per_night;
                                                        } else {
                                                            $price = $model->price_per_person ?? 0;
                                                        }
                                                        $set('price_at_time', $price);
                                                        self::updateTotalPrice($get, $set);
                                                    }
                                                }
                                            }),
                                        Forms\Components\TextInput::make('quantity')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(Forms\Get $get, Forms\Set $set) => self::updateTotalPrice($get, $set)),
                                        Forms\Components\TextInput::make('price_at_time')
                                            ->numeric()
                                            ->prefix('$')
                                            ->required()
                                            ->readOnly()
                                            ->default(0),
                                    ])
                                    ->columns(3)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('notes')
                                    ->label('Admin Notes (Internal)')
                                    ->rows(3)
                                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('booking_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'individual' => 'gray',
                        'agency' => 'primary',
                        default => 'gray',
                    }),
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
