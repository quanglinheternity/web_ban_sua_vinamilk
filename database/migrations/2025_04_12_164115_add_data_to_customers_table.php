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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('anh_dai_dien')->nullable(); // Lưu đường dẫn ảnh đại diện
            $table->date('ngay_sinh')->nullable(); // Ngày sinh
            $table->enum('gioi_tinh', ['nam', 'nu', 'khac'])->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['anh_dai_dien', 'ngay_sinh', 'gioi_tinh', 'user_id']);
        });
    }
};
