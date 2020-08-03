<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Notifications\UserNotification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
		$users = App\Models\User::all();
		foreach ($users as $user) {	  
			$count = 0;
			while($count < 20) {
            	$user->notify(new UserNotification(['text' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))), 
            										'link' => $faker->url(), 
            										'icon' => 'bell']));
				$count++;
			}              
		}
    }
}
