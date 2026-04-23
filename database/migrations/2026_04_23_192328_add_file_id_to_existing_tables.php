<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add file_id to tents
        Schema::table('tents', function (Blueprint $table) {
            $table->foreignId('file_id')->nullable()->after('image')->constrained('files')->nullOnDelete();
        });

        // Add file_id to activities
        Schema::table('activities', function (Blueprint $table) {
            $table->foreignId('file_id')->nullable()->after('image')->constrained('files')->nullOnDelete();
        });

        // Add file_id to gallery_items
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->foreignId('file_id')->nullable()->after('image_path')->constrained('files')->nullOnDelete();
        });

        // Migrate existing data
        $this->migrateExistingFiles();
    }

    protected function migrateExistingFiles()
    {
        // Tents
        $tents = DB::table('tents')->whereNotNull('image')->get();
        foreach ($tents as $tent) {
            $fileId = DB::table('files')->insertGetId([
                'path' => $tent->image,
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('tents')->where('id', $tent->id)->update(['file_id' => $fileId]);
        }

        // Activities
        $activities = DB::table('activities')->whereNotNull('image')->get();
        foreach ($activities as $activity) {
            $fileId = DB::table('files')->insertGetId([
                'path' => $activity->image,
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('activities')->where('id', $activity->id)->update(['file_id' => $fileId]);
        }

        // Gallery Items
        $gallery = DB::table('gallery_items')->whereNotNull('image_path')->get();
        foreach ($gallery as $item) {
            $fileId = DB::table('files')->insertGetId([
                'path' => $item->image_path,
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('gallery_items')->where('id', $item->id)->update(['file_id' => $fileId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('file_id');
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->dropConstrainedForeignId('file_id');
        });
        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('file_id');
        });
    }
};
