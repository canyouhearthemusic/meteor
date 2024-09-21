<?php

namespace Database\Seeders;

use App\Models\BookType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BookTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            BookType::create(['name' => 'Аудиокнига']);

            BookType::create(['name' => 'Физическая книга']);
        });
    }
}
