<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldProducts extends Command
{
    protected $signature = 'products:delete-old';
    protected $description = 'Xóa vĩnh viễn sản phẩm đã xóa mềm sau 30 ngày';

    public function handle()
    {
        $date = Carbon::now()->subDays(30);
        $deletedProducts = Product::onlyTrashed()->where('deleted_at', '<=', $date)->forceDelete();

        $this->info("Đã xóa vĩnh viễn {$deletedProducts} sản phẩm cũ.");
    }
}
