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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('id');
            $table->string('code', 20)->unique();
            $table->string('name', 150);
            $table->text('address')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('contact_person', 150)->nullable();
            $table->string('contact_person_email', 255)->nullable();
            $table->string('contact_person_phone', 20)->nullable();
            $table->string('registration_no', 255)->nullable();
            $table->string('tax_no', 25)->nullable();
            $table->integer('vat')->default(0);
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_account_no', 25)->nullable();
            $table->string('bank_account_name', 150)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->enum('payment_method', ['cash', 'bank', 'cheque', 'term_30', 'term_60', 'term_90'])->default('term_30');
            $table->text('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
