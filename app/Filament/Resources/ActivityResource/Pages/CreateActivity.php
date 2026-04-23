<?php

namespace App\Filament\Resources\ActivityResource\Pages;

use App\Filament\Resources\ActivityResource;
use App\Models\File;
use Filament\Resources\Pages\CreateRecord;

class CreateActivity extends CreateRecord
{
    protected static string $resource = ActivityResource::class;

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

        unset($data['image_temp']);

        return $data;
    }
}
