<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
	use Notifiable;

    use SoftDeletes;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'google_id', 'facebook_id', 'email_verified_at', 'password', 'last_login_at', 'last_login_ip'
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
        'last_login_at' => 'datetime'
    ];

    public function scopeSearch($query, $search='')
    {
        if (empty($search)) {
            return $query;
        } else {
            return $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('username', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('user_detail', function ($query) use($search){
                        $query->where('address', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('user_detail', function ($query) use($search){
                        $query->where('contact', '=', $search );
                    });
        }
    }

    // each user has a user detail
    public function user_detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    // A User perticipated in many messages subjects
    public function message_subjects() {
        return $this->belongsToMany(MessageSubject::class, 'message_participants');
    }

    // A User viewed many messages
    public function viewed()
    {
        return $this->hasMany(MessageViewer::class);
    }
}
