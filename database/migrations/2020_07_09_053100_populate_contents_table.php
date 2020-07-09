<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('contents')->insert([ 'headline' => 'welcome', 'web_contents' => json_encode([]) ]);
        DB::table('contents')->insert([ 'headline' => 'about_us', 'web_contents' => json_encode([]) ]);
        DB::table('contents')->insert([ 'headline' => 'terms_of_use', 'web_contents' => json_encode([]) ]);
        DB::table('contents')->insert([ 'headline' => 'privacy_policy', 'web_contents' => json_encode([]) ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('contents')->truncate();
    }
}
