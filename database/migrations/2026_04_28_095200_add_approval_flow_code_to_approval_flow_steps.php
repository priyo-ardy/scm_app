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
        Schema::table('approval_steps', function (Blueprint $table) {
            $table->string('approval_flow_code')->nullable()->after('approval_flow_id');


            $table->foreign('approval_flow_code')
                ->references('code')
                ->on('approval_flows')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approval_steps', function (Blueprint $table) {
            $table->dropForeign(['approval_flow_code']);

            $table->dropColumn('approval_flow_code');
        });
    }
};
