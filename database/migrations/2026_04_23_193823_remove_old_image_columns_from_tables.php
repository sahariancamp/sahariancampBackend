<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tents', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tents', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            $table->string('image_path')->nullable();
        });
    }
};
