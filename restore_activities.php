<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\File;
use App\Models\Activity;
use Illuminate\Support\Facades\Http;

$mapping = [
    1 => 'https://sahariancamp.com/wp-content/uploads/2021/02/travelofmorocco_desert-72.jpg',
    2 => 'https://sahariancamp.com/wp-content/uploads/2021/02/Merzouga-Buggy-Price.webp',
    3 => 'https://sahariancamp.com/wp-content/uploads/2021/02/merzouga-sandboarding-3.jpg',
    4 => 'https://sahariancamp.com/wp-content/uploads/2021/02/DSC_0798-1.jpg',
    5 => 'https://sahariancamp.com/wp-content/uploads/2021/02/travelofmorocco_desert-47.jpg',
];

$outputDir = 'C:\\Saharian_Restored_Activities\\';
if (!is_dir($outputDir)) mkdir($outputDir, 0777, true);

foreach ($mapping as $id => $url) {
    echo "Processing Activity ID $id: $url\n";
    try {
        $response = Http::get($url);
        if ($response->successful()) {
            $ext = pathinfo($url, PATHINFO_EXTENSION) ?: 'jpg';
            // Generate a 26 character uppercase hex string to look like a ULID/ObjectID
            $objectId = strtoupper(bin2hex(random_bytes(13)));
            $filename = $objectId . '.' . $ext;
            
            // Save to external folder
            file_put_contents($outputDir . $filename, $response->body());
            
            // Create record in DB pointing to where it SHOULD be on R2
            $file = File::create([
                'path' => 'activities/' . $filename,
                'disk' => 'failover'
            ]);
            
            $activity = Activity::find($id);
            if ($activity) {
                $activity->update(['file_id' => $file->id]);
                echo "Successfully restored $id as $filename\n";
            }
        } else {
            echo "Failed to download $url\n";
        }
    } catch (\Exception $e) {
        echo "Error processing $id: " . $e->getMessage() . "\n";
    }
}
