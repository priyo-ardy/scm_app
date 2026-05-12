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
        Schema::table('purchase_requisition_details', function (Blueprint $table) {
            $table->decimal('qty_remaining', 15, 4)->after('qty_ordered')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_requisition_details', function (Blueprint $table) {
            $table->dropColumn('qty_remaining');
        });
    }
};
