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
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->foreignId('created_by')->after('created_at')->nullable()->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->after('updated_at')->nullable()->constrained('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropForeign('created_by');
            $table->dropForeign('updated_by');
        });

        Schema::table(
            'payment_methods',
            function (Blueprint $table) {

                $table->dropColumn(['created_by', 'updated_by']);
            }
        );
    }
};
