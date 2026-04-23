<?php

namespace App\Filament\Resources\TentResource\Pages;

use App\Filament\Resources\TentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTent extends EditRecord
{
    protected static string $resource = TentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
