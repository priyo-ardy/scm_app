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
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name', 150);
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->text('location_detail')->nullable();
            $table->foreignId('pic_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('phone', 20)->nullable();
            $table->text('remarks')->nullable();
            $table->text('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};
