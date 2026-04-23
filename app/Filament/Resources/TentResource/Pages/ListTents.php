<?php

namespace App\Filament\Resources\TentResource\Pages;

use App\Filament\Resources\TentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTents extends ListRecords
{
    protected static string $resource = TentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
