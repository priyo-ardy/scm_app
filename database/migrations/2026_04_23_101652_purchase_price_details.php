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
        Schema::create('purchase_price_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('header_id')->constrained('purchase_price_headers')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('materials')->restrictOnDelete();
            $table->foreignId('unit_id')->constrained('units')->restrictOnDelete();
            $table->decimal('from_qty', 15, 4)->default(0);
            $table->decimal('to_qty', 15, 4)->default(0);
            $table->decimal('unit_price', 15, 4)->default(0);
            $table->decimal('unit_price_after_tax', 15, 4)->default(0);
            $table->decimal('tax_rate', 12, 2)->default(0);
            $table->date('effective_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_price_details');
    }
};
