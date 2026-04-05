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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            // Dasar
            $table->string('code', 10)->unique(); // Misal: MJB
            $table->string('name');
            $table->string('legal_name')->nullable(); // PT. Maju Jaya Bersama
            $table->string('slug')->unique();

            // Kontak & Alamat
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code', 5)->nullable();

            // Pajak (Legal)
            $table->string('tax_id')->nullable(); // NPWP
            $table->string('tax_address')->nullable(); // Alamat di NPWP
            $table->boolean('is_pkp')->default(false);

            // Finance (Default Payment Info)
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_beneficiary')->nullable(); // Atas Nama

            // Branding
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            $table->timestamps();
            $table->softDeletes(); // Disarankan agar data master tidak hilang permanen

            $table->foreignId('currency_id')->nullable()->constrained('currencies')->onDelete('set null');
            $table->foreignId('timezone_id')->nullable()->constrained('time_zones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
