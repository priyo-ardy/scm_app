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
        Schema::table('equipments', function (Blueprint $table) {
            $table->boolean('is_active')->after('status')->default(true);
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
        Schema::table('equipments', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);

            $table->dropColumn(['is_active', 'created_by', 'updated_by']);
            $table->dropSoftDeletes();
        });
    }
};
