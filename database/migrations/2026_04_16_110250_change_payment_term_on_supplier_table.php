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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->foreignId('company_id')->after('id')->constrained('companies')->restrictOnDelete();
            $table->foreignId('payment_term_id')
                ->nullable()
                ->after('avatar')
                ->constrained('payment_terms')
                ->nullOnDelete();
            $table->boolean('is_active')
                ->default(true)
                ->after('payment_term_id');
            $table->enum('category', ['local', 'export'])->default('local')->after('is_active');
            $table->foreignId('default_currency')->constrained('currencies')->restrictOnDelete()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['payment_term_id']);
            $table->dropForeign(['default_currency']);

            $table->dropColumn('company_id');
            $table->dropColumn('payment_term_id');
            $table->dropColumn('is_active');
            $table->dropColumn('category');
            $table->dropColumn('default_currency');

            // Kembalikan ke enum jika rollback
            $table->enum('payment_method', ['cash', 'bank', 'cheque', '30', '60', '90'])->default('30')->after('avatar');
        });
    }
};
