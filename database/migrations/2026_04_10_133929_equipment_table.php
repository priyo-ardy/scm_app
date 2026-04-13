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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('equipment_categories')->onDelete('set null');
            $table->string('code', 25)->unique();
            $table->string('equipment_no', 50)->nullable();
            $table->string('name', 150);
            $table->text('specification');
            $table->foreignId('tonnage_id')->nullable()->constrained('tonnages')->onDelete('set null');
            $table->string('brand')->nullable();
            $table->string('model_number')->nullable();
            $table->string('serial_number')->unique()->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('machine_rate')->nullable();
            $table->enum('status', ['running', 'standby', 'breakdown', 'repair'])->default('running');
            $table->date('installation_date')->nullable();
            $table->unsignedBigInteger('total_shots')->default(0);
            $table->date('last_maintenance')->nullable();
            $table->string('avatar')->nullable();
            $table->foreignId('workshop_id')->nullable()->constrained('workshops')->onDelete('set null');
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('equipments');

        // Hidupkan kembali
        Schema::enableForeignKeyConstraints();
    }
};
