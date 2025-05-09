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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('don_hang_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('san_pham_bien_the_id')->constrained('detail_product_variants')->onDelete('cascade');
            $table->foreignId('size_ml_id')->constrained('size_mls')->onDelete('cascade');
            $table->foreignId('size_box_id')->constrained('size_boxes')->onDelete('cascade');
            $table->integer('so_luong');
            $table->decimal('tong_tien', 10, 2);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
