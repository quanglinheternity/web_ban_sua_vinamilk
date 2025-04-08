<?php

namespace App\Console\Commands;

use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteOldBanners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'banners:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xóa vĩnh viễn các banner đã bị xóa mềm hơn 30 ngày trước';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Lấy danh sách banners đã xóa mềm quá 30 ngày
        $banners = Banner::onlyTrashed()
            ->where('deleted_at', '<=', Carbon::now()->subDays(30))
            ->get();

        // Đếm số lượng để log
        $count = $banners->count();

        if ($count === 0) {
            $this->info('Không có banner nào cần xóa.');
            return;
        }

        foreach ($banners as $banner) {
            // Xóa ảnh nếu có
            if (!empty($banner->image) && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            // Xóa vĩnh viễn banner
            $banner->forceDelete();
        }

        $this->info("$count banner(s) đã bị xóa vĩnh viễn.");
    }
}
