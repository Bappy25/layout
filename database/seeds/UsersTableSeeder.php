<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // App\Models\User::truncate(); // delete all previous rows
        factory(App\Models\User::class, 20)->create(); // Create 20 rows
    }
}
