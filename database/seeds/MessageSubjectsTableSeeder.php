<?php

use Illuminate\Database\Seeder;

class MessageSubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // App\Models\MessageSubject::truncate(); // delete all previous rows
		factory(App\Models\MessageSubject::class, 20)->create(); // Create 20 rows
    }
}
