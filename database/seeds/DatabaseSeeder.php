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
        $this->call(UsersSeeder::class);
        $this->command->info('Seeded the users!');

            // Seed the user details
        $this->call(AdminsSeeder::class);
        $this->command->info('Seeded the administrators!');

            // Seed the user details
        $this->call(UserDetailsSeeder::class);
        $this->command->info('Seeded the user details!');
    }
}
