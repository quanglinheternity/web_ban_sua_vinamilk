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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ma_don_hang');
            $table->foreignId('tai_khoan_id')->constrained('users')->onDelete('cascade');
            $table->string('ten_nguoi_nhan');
            $table->string('so_dien_thoai');
            $table->string('dia_chi_nhan_hang');
            $table->dateTime('ngay_dat_hang');
            $table->decimal('tong_tien', 10, 2);
            $table->foreignId('trang_thai_id')->constrained('order_statuses')->onDelete('cascade');
            $table->foreignId('phuong_thuc_id')->constrained('payment_methods')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
