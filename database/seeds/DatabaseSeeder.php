<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    		// Seed the users
    	$this->call(UsersTableSeeder::class);
    	$this->command->info('Seeded the users!');

    		// Seed the admins
    	$this->call(AdminsTableSeeder::class);
    	$this->command->info('Seeded the admins!');
    }
}
