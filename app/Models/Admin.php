<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
	use Notifiable;
	
	protected $table = "admins";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    	'email_verified_at' => 'datetime',
    ];

    public function scopeSearch($query, $search='')
    {
        if (empty($search)) {
            return $query->orderByRaw("created_at", 'DESC');
        } else {      
            return $query->orderByRaw("created_at", 'DESC')
                         ->WhereRaw("name LIKE ? ", '%' . $search . '%')
                         ->orWhere('email', 'LIKE', '%' . $search . '%');
        }
    }
}
