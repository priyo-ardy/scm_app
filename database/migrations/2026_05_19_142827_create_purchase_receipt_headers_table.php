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
        Schema::create('purchase_receipt_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->restrictOnDelete();
            $table->string('code', 20)->unique();

            $table->date('doc_date')->nullable();
            $table->date('received_date')->nullable();

            $table->string('doc_status')->nullable();
            $table->boolean('is_closed')->default(false);

            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->foreignId('currency_id')->constrained('currencies')->restrictOnDelete();
            $table->decimal('exchange_rate', 15, 4)->default(1);

            $table->string('delivery_note_number', 50)->nullable();
            $table->string('vehicle_number', 30)->nullable();

            $table->string('qc_status')->default('pending');

            $table->foreignId('received_by')->nullable()->constrained('users')->restrictOnDelete();
            $table->integer('print_count')->default(0);
            $table->text('remark')->nullable();

            $table->timestamps();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::create('purchase_receipt_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id')->constrained('purchase_receipt_headers')->cascadeOnDelete();
            $table->foreignId('po_id')->nullable()->constrained('purchase_order_headers')->nullOnDelete();
            $table->foreignId('po_detail_id')->nullable()->constrained('purchase_order_details')->nullOnDelete();
            $table->foreignId('material_id')->constrained('materials')->restrictOnDelete();
            $table->foreignId('units_id')->constrained('units')->restrictOnDelete();
            $table->decimal('qty_ordered', 15, 4)->default(0);
            $table->decimal('qty_received', 15, 4)->default(0);
            $table->decimal('qty_rejected', 15, 4)->default(0);
            $table->decimal('qty_remaining', 15, 4)->default(0);
            $table->boolean('is_closed')->default(false);
            $table->string('lot_number', 50)->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receipt_headers');
        Schema::dropIfExists('purchase_receipt_details');
    }
};
