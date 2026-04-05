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
        Schema::create('time_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();    // Misal: Asia/Jakarta, Asia/Makassar
            $table->string('offset');            // Misal: +07:00, +08:00
            $table->string('description')->nullable(); // Misal: Western Indonesia Time
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_zones');
    }
};
