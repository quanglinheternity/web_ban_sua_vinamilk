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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_code')->nullable()->after('id');
            $table->string('email_nguoi_nhan')->nullable()->after('ten_nguoi_nhan');
            $table->text('ghi_chu')->nullable()->after('dia_chi_nhan_hang');
            $table->string('trang_thai_thanh_toan')->default('pending')->after('phuong_thuc_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_code', 'email_nguoi_nhan', 'ghi_chu', 'trang_thai_thanh_toan']);
        });
    }
};
