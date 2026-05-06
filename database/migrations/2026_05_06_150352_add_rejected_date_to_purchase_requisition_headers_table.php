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
        Schema::table('purchase_requisition_headers', function (Blueprint $table) {
            $table->date('reject_date')->nullable()->after('reject_reason');
            $table->foreignId('rejected_by')->nullable()->after('reject_date')->constrained('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_requisition_headers', function (Blueprint $table) {
            $table->dropForeign(['rejected_by']);

            $table->dropColumn(['reject_date', 'rejected_by']);
        });
    }
};
