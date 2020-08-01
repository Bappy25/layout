<?php

use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // App\Models\News::truncate(); // delete all previous rows
        factory(App\Models\News::class, 15)->create(); // Create 15 rows
    }
}
