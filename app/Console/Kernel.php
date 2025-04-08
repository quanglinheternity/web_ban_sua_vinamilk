<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Đăng ký lịch trình chạy các lệnh Artisan.
     */
    protected function schedule(Schedule $schedule)
    {
        // 🔥 Xóa vĩnh viễn các bản ghi đã bị xóa mềm sau 30 ngày
        $schedule->call(function () {
            $tables = ['customers', 'categories', 'products', 'banners', 'reviews', 'posts','contacts']; // Bổ sung bảng cần xóa

            foreach ($tables as $table) {
                $deletedRecords = DB::table($table)
                    ->whereNotNull('deleted_at')
                    ->where('deleted_at', '<=', Carbon::now()->subDays(30))
                    ->delete(); // Nếu dùng model, có thể dùng ->forceDelete()

                echo "🔴 Đã xóa vĩnh viễn $deletedRecords bản ghi trong bảng $table.\n";
            }
        })->dailyAt('00:00');

        // 🧹 Dọn dẹp cache mỗi Chủ Nhật lúc 3h sáng
        $schedule->command('cache:clear')->weeklyOn(7, '03:00');

        // 📌 Chỉ chạy queue nếu có công việc trong hàng đợi
        $schedule->command('queue:work --stop-when-empty')->everyMinute()->when(function () {
            return DB::table('jobs')->exists();
        });

        // 💾 Backup database hàng ngày vào lúc 2h sáng
        $schedule->command('backup:run')->dailyAt('02:00');
    }

    /**
     * Đăng ký các command có sẵn trong thư mục Commands.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
