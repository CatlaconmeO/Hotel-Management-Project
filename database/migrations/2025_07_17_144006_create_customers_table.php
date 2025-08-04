<?php

use App\Models\Team;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('password');
            $table->string('phone')->required();
            $table->timestamp('date_of_birth')->nullable();
            $table->string('address');
            $table->string('identity_number');
            $table->enum('customer_type', ['regular', 'vip'])->default('regular');
            $table->foreignIdFor(Team::class)->nullable()->constrained()->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
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
