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
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('company_id')->after('id')->nullable()->constrained('companies')->restrictOnDelete();
            $table->enum('category', ['local', 'overseas'])->after('company_id')->nullable();
            $table->boolean('is_active')->after('category')->default(true);
            $table->foreignId('currency_id')->after('avatar')->constrained('currencies')->restrictOnDelete();
            $table->dropColumn('payment_method');
            $table->foreignId('payment_term_id')->nullable()->after('avatar')->constrained('payment_terms')->restrictOnDelete();
            $table->foreignId('created_by')->nullable()->after('created_at')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->after('updated_at')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['payment_term_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            $table->dropColumn(['company_id', 'category', 'is_active', 'currency_id', 'payment_term_id', 'created_by', 'updated_by']);

            $table->enum('payment_method', ['cash', 'bank', 'cheque', 'term_30', 'term_60', 'term_90'])->default('term_30');
        });
    }
};
