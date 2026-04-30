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
        // 1. Tabel Master Approval Flows
        Schema::create('approval_flows', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 150);
            $table->text('remark')->nullable(); // Dibuat nullable agar tidak error jika kosong
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
        });

        // 2. Tabel Detail Stages (Tahapan)
        Schema::create('approval_steps', function (Blueprint $table) {
            $table->id();
            // Cukup gunakan ID untuk relasi, hindari redundansi dengan code
            $table->foreignId('approval_flow_id')->constrained('approval_flows')->cascadeOnDelete();
            $table->integer('order')->default(1);
            $table->string('approver_role', 50);
            $table->foreignId('approver_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            // Mencegah ada urutan/order yang sama di dalam satu flow ID yang sama
            $table->unique(['approval_flow_id', 'order']);
        });

        // 3. Tabel Transaksi Logs
        Schema::create('approval_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_flow_id')->constrained('approval_flows')->cascadeOnDelete();

            // Menggantikan doc_id. Ini otomatis membuat 2 kolom: document_type (string) & document_id (bigint)
            $table->morphs('document');

            $table->integer('current_step_order');
            $table->foreignId('current_approver_id')->nullable()->constrained('users')->restrictOnDelete();

            // Menggunakan string untuk status agar lebih mudah dibaca (pending, approved, rejected)
            $table->string('status', 20)->default('pending');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_logs');
        Schema::dropIfExists('approval_stages');
        Schema::dropIfExists('approval_flows');
    }
};
