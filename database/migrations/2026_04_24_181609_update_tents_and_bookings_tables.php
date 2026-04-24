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
            $table->decimal('agency_price', 10, 2)->after('price_per_night')->nullable()->comment('Special price for agencies');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('booking_type', ['individual', 'agency'])->default('individual')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tents', function (Blueprint $table) {
            $table->dropColumn('agency_price');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('booking_type');
        });
    }
};
