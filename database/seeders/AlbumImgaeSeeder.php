<?php

namespace Database\Seeders;

use App\Models\AlbumImgae;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumImgaeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AlbumImgae::factory()->count(10)->create();
    }
}
