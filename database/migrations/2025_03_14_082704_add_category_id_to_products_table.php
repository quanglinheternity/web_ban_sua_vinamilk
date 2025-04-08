<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cập nhật bảng products để liên kết với categories
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // $table->unsignedInteger('categroy_id')->after('ten_san_pham')->nullable();
            // nối khóa
            $table->foreignId('category_id')->nullable()->after('ten_san_pham')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
