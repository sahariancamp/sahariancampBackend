<?php

namespace App\Filament\Resources\TentResource\Pages;

use App\Filament\Resources\TentResource;
use App\Models\File;
use Filament\Resources\Pages\CreateRecord;

class CreateTent extends CreateRecord
{
    protected static string $resource = TentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['image_temp'])) {
            $path = is_array($data['image_temp']) ? reset($data['image_temp']) : $data['image_temp'];

            if ($path) {
                $file = File::create([
                    'path' => $path,
                    'disk' => 'failover',
                ]);
                $data['file_id'] = $file->id;
            }
        }

        // Remove the temporary field so Laravel doesn't try to save it to the database
        unset($data['image_temp']);

        return $data;
    }
}
