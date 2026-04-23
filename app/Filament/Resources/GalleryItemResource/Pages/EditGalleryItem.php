<?php

namespace App\Filament\Resources\GalleryItemResource\Pages;

use App\Filament\Resources\GalleryItemResource;
use App\Models\File;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGalleryItem extends EditRecord
{
    protected static string $resource = GalleryItemResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['image_temp'])) {
            $path = is_array($data['image_temp']) ? reset($data['image_temp']) : $data['image_temp'];

            if ($path && $path !== $this->record->file?->path) {
                // Delete old file
                $this->record->file?->delete();

                $file = File::create([
                    'path' => $path,
                    'disk' => 'failover',
                ]);
                $data['file_id'] = $file->id;
            }
        }

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
