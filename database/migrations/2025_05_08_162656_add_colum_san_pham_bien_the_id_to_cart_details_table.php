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
        Schema::table('cart_details', function (Blueprint $table) {
            $table->foreignId('san_pham_bien_the_id')->constrained('detail_product_variants')->onDelete('cascade')->after('san_pham_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_details', function (Blueprint $table) {
            $table->dropForeign(['san_pham_bien_the_id']);
            $table->dropColumn('san_pham_bien_the_id');
        });
    }
};
