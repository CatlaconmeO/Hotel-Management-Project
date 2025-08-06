<?php

use App\Models\Room;
use App\Models\Team;
use App\Models\Branch;
use App\Models\Customer;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->foreignIdFor(Branch::class);
            $table->foreignId('voucher_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('discount_amount')->default(0);
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'refunded'])->default('pending');
            $table->foreignIdFor(Team::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
