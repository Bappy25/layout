<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageSubject extends Model
{
    protected $table = "message_subjects";

    protected $fillable = ['subject'];

    use SoftDeletes;

    public function scopeSearch($query, $search='')
    {
        if (empty($search)) {
            return $query;
        } else {
            return $query->where('subject', 'LIKE', '%' . $search . '%');
        }
    }

        // A Message Subject has many messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

        // A Message Subject has many participants
    public function participants()
    {
        return $this->belongsToMany(User::class, 'message_participants');
    }

        // Each message has many offers
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_messages');
    }
}
