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
        Schema::create('purchase_requisition_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_requisition_header_id')
                ->constrained('purchase_requisition_headers', 'id')
                ->cascadeOnDelete()
                ->name('pr_header_id_foreign');
            $table->foreignId('material_id')->constrained('materials')->restrictOnDelete();
            $table->foreignId('unit_id')->constrained('units')->restrictOnDelete();
            $table->decimal('qty', 15, 4)->default(0);
            $table->decimal('qty_approved', 15, 4)->default(0);
            $table->decimal('qty_ordered', 15, 4)->default(0);
            $table->decimal('estimated_price', 15, 4)->default(0);
            $table->decimal('subtotal', 15, 4)->default(0);
            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers')
                ->restrictOnDelete(); // Untuk default supplier jika ada;
            $table->date('arrival_date')->index(); // User dapat menentukan kapan barang datang
            $table->enum('item_status', ['open', 'partially_ordered', 'closed', 'rejected'])->default('open');
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->constrained('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_details');
    }
};
