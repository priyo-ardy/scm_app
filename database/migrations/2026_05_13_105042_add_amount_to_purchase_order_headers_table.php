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
        Schema::table('purchase_order_headers', function (Blueprint $table) {
            $table->decimal('amount', 15, 4)->after('supplier_id')->default(0);
            $table->decimal('total_discount', 15, 4)->after('amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_order_headers', function (Blueprint $table) {
            $table->dropColumn(['amount', 'total_discount']);
        });
    }
};
