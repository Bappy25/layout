<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as DB;

class UserDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {        

            //Empty the user_details table
        // DB::table('user_details')->delete();
        
        $userIds = App\Models\User::all()->pluck('id')->toArray();

    	if(count($userIds) > 0){
        	foreach ($userIds as $user) {	                
                $data = [
                    [
                        "user_id"  => $user,
                        'address' => $faker->address,
                        'dob' => strftime("%Y-%m-%d"),
                        'contact' => $faker->phoneNumber,
                        "created_at"  => strftime("%Y-%m-%d %H:%M:%S"),
                        "updated_at"  => strftime("%Y-%m-%d %H:%M:%S")
                    ]
                ];

            	DB::table("user_details")->insert($data);
			}  	
        }
    }
}
