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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã voucher
            $table->enum('type', ['fixed', 'percent'])->default('fixed'); // Loại giảm giá: cố định hoặc theo %
            $table->decimal('amount', 10, 2); // Giá trị giảm
            $table->decimal('min_order_value', 10, 2)->nullable(); // Giá trị đơn tối thiểu để áp dụng
            $table->integer('max_uses')->nullable(); // Tổng số lượt sử dụng
            $table->integer('used_count')->default(0); // Số lượt đã sử dụng
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');
            $table->foreignIdFor(Team::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
