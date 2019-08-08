<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // App\Models\Admin::truncate(); // delete all previous rows
        factory(App\Models\Admin::class, 20)->create(); // Create 20 rows
    }
}
