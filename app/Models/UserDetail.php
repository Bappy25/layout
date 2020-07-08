<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    //
    use SoftDeletes;
    
    protected $table = "user_details";

    protected $fillable = [
        'address', 'dob', 'contact', 'gender', 'avatar', 'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = ['dob'];

    	// Each user details belong to a user
	public function user()
	{
		return $this->belongsTo(User::class);
	}    
}
