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
            $table->id();
            $table->string('name')->required();
            $table->string('email')->unique();
            $table->string('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->required();
            $table->string('address');
            $table->string('identity_number');
            $table->enum('customer_type', ['regular', 'vip']);
            $table->timestamps();
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
