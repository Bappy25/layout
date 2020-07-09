<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as DB;

class MessageParticipantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
            //Empty the message_participants table
        // DB::table('message_participants')->delete();

		$userIds = App\Models\User::all()->pluck('id')->toArray();
    	$messageSubjectIds = App\Models\MessageSubject::all()->pluck('id')->toArray();

    	if(count($messageSubjectIds) > 0 && count($userIds) > 0){
            foreach ($messageSubjectIds as $messageSubject) {
            	foreach ($userIds as $user) {	                
	                $data = [
	                    [
	                        "user_id"  => $user,
	                        "message_subject_id"  => $messageSubject,
                            "created_at"  => strftime("%Y-%m-%d %H:%M:%S"),
                            "updated_at"  => strftime("%Y-%m-%d %H:%M:%S")
	                    ]
	                ];

                	DB::table("message_participants")->insert($data);
				}  	
            }

        }
    }
}
