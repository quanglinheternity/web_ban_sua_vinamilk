<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'records:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xóa vĩnh viễn các bản ghi đã bị xóa mềm sau 30 ngày';

    /**
     * Execute the console command.
     */
    public function handle()
    {

    }
}
