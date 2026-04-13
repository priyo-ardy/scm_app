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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('restrict');
            $table->foreignId('category_id')->constrained('material_categories')->onDelete('restrict');
            $table->string('code', 150)->unique();
            $table->string('name', 150);
            $table->text('specification');
            $table->foreignId('unit_id')->constrained('units')->onDelete('restrict');
            $table->foreignId('purchase_unit_id')->constrained('units')->onDelete('restrict');
            $table->decimal('unit_conversion_rate', 12, 4)->default(1);
            $table->integer('spq')->default(1);
            $table->integer('qty_bag')->default(0);
            $table->decimal('net_weight', 12, 2)->default(0);
            $table->decimal('gross_weight', 12, 2)->default(0);
            $table->decimal('sprue', 12, 2)->default(0);
            $table->decimal('cycle_time', 8, 2)->default(0);
            $table->integer('shift_capacity')->default(0);
            $table->enum('properties', ['purchase', 'self_made', 'sub_contract', 'configure', 'asset', 'feature', 'expense', 'virtual', 'service'])->default('purchase');
            $table->string('color', 20)->nullable();
            $table->integer('cavity')->default(0);
            $table->foreignId('workshop_id')->constrained('workshops')->onDelete('restrict');
            $table->string('cust_part_no', 150)->nullable();
            $table->string('cust_part_name', 150)->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('enable_min_stock')->default(false);
            $table->decimal('min_stock')->default(0);
            $table->boolean('enable_safety_stock')->default(false);
            $table->decimal('safety_stock')->default(0);
            $table->boolean('enabl_max_stock')->default(false);
            $table->decimal('max_stock')->default(0);
            $table->decimal('reorder_point')->default(0);
            $table->text('description')->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('restrict');
            $table->boolean('is_hazardous')->default(false);
            $table->string('storage_location_id');
            $table->boolean('enable_expired')->default(false);
            $table->integer('expiry_days')->default(0);
            $table->integer('lead_time_days')->default(0);
            $table->enum('status', ['draft', 'active', 'phase_out', 'obsolete']);
            $table->string('revision_no', 10)->nullable();
            $table->string('hs_code', 50)->nullable();
            $table->enum('regrind_method', ['inline', 'offline', 'no_regrind']);
            $table->decimal('carton_length', 12, 4)->default(0);
            $table->decimal('carton_width', 12, 4)->default(0);
            $table->decimal('carton_height', 12, 4)->default(0);
            $table->foreignId('dimension_unit_id')->constrained('units')->onDelete('restrict');
            $table->integer('stacking_limit')->default(0);
            $table->boolean('is_inspection_required')->default(false);
            $table->decimal('last_purchase_price', 15, 2)->default(0);
            $table->json('images')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('updated_by')->constrained('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
