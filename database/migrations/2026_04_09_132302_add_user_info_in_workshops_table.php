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
        Schema::table('workshops', function (Blueprint $table) {
            $table->foreignId('company_id')->after('id')->nullable()->constrained('companies')->restrictOnDelete();
            $table->foreignId('created_by')->after('created_at')->nullable()->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->after('updated_at')->nullable()->constrained('users')->restrictOnDelete();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn(['company_id', 'created_by', 'updated_by']);
            $table->dropSoftDeletes();
        });
    }
};
