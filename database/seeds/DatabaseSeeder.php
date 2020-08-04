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
        $this->call(UserDetailsSeeder::class);
        $this->command->info('Seeded the user details!');

            // Seed the notifications
        $this->call(NotificationSeeder::class);
        $this->command->info('Seeded the notifications!');

            // Seed the message subjects
        $this->call(MessageSubjectsTableSeeder::class);
        $this->command->info('Seeded the message subjects!');

            // Seed the messages
        $this->call(MessagesTableSeeder::class);
        $this->command->info('Seeded the messages!');

            // Seed the message participants
        $this->call(MessageParticipantsTableSeeder::class);
        $this->command->info('Seeded the message participants!');

            // Seed the admins
        $this->call(AdminsSeeder::class);
        $this->command->info('Seeded the administrators!');

            // Seed the news
        $this->call(NewsSeeder::class);
        $this->command->info('Seeded the news!');
    }
}
