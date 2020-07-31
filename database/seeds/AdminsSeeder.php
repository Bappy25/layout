<?php

use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // App\Models\Administrator::truncate(); // delete all previous rows
        factory(App\Models\Admin::class, 5)->create(); // Create 5 rows
    }
}
