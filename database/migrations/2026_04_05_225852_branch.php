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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();

            $table->string('code')->unique(); // Misal: PLT-01, PLT-02
            $table->string('name');           // Misal: Plant Bekasi, Plant Karawang
            $table->enum('category', ['plant', 'warehouse', 'office'])->default('plant');

            // Khusus Operasional Pabrik
            $table->string('phone_ext')->nullable(); // Extension telp internal pabrik
            $table->string('manager_name')->nullable();
            $table->integer('total_manpower')->default(0); // Jumlah karyawan di plant tersebut

            // Alamat & Logistik
            $table->text('address')->nullable();
            $table->string('map_url')->nullable(); // Link Google Maps untuk supir logistik

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
        Schema::dropIfExists('branches');
    }
};
