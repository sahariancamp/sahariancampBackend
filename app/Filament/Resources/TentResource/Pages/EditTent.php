<?php

namespace App\Filament\Resources\TentResource\Pages;

use App\Filament\Resources\TentResource;
use App\Models\File;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTent extends EditRecord
{
    protected static string $resource = TentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['image_temp'])) {
            $path = is_array($data['image_temp']) ? reset($data['image_temp']) : $data['image_temp'];

            if ($path && $path !== $this->record->file?->path) {
                // Delete the old file record and its physical file
                $this->record->file?->delete();

                $file = File::create([
                    'path' => $path,
                    'disk' => 'failover',
                ]);
                $data['file_id'] = $file->id;
            }
        }

        // Remove the temporary field
        unset($data['image_temp']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
