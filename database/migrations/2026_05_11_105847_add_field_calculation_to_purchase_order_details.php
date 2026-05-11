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
        Schema::table('purchase_order_details', function (Blueprint $table) {
            $table->decimal('amount', 15, 4)->default(0)->after('unit_price');
            $table->decimal('price_after_discount', 15, 4)->default(0)->after('discount_amount');
            $table->decimal('price_after_tax', 15, 4)->default('0')->after('tax_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_order_details', function (Blueprint $table) {
            $table->dropColumn(['amount', 'price_after_discount', 'price_after_tax']);
        });
    }
};
