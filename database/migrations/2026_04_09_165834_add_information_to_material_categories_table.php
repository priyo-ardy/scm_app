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
        Schema::table('material_categories', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id')->constrained('companies')->restrictOnDelete();
            $table->foreignId('created_by')->nullable()->after('created_at')->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->nullable()->after('updated_at')->constrained('users')->restrictOnDelete();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_categories', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updatedd_by']);

            $table->dropColumn(['company_id', 'created_by', 'updated_by']);

            $table->dropSoftDeletes();
        });
    }
};
