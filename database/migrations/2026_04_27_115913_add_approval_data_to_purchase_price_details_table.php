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
        Schema::table('purchase_price_details', function (Blueprint $table) {
            $table->enum('approval_status', ['waiting_approval', 'approved', 'reject'])->after('is_active')->default('waiting_approval');
            $table->foreignId('approved_by')->nullable()->after('approval_status')->constrained('users')->restrictOnDelete();
            $table->dateTime('approved_date')->nullable()->after('approved_by');
            $table->foreignId('rejected_by')->nullable()->after('approved_date')->constrained('users')->restrictOnDelete();
            $table->dateTime('rejected_date')->nullable()->after('rejected_by');
            $table->text('reject_reason')->nullable()->after('rejected_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_price_details', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);

            $table->dropColumn(['approval_status', 'approved_by', 'approved_date', 'rejected_by', 'rejected_date', 'reject_reason']);
        });
    }
};
