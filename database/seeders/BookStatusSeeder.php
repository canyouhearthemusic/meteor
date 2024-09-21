<?php

namespace Database\Seeders;

use App\Models\BookStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BookStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            BookStatus::create(['name' => 'К прочтению']);
            BookStatus::create(['name' => 'Читаю']);
            BookStatus::create(['name' => 'Уже прочитал']);
        });
    }
}
