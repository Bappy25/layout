<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageViewer extends Model
{
    protected $table = "message_viewers";

    protected $fillable = ['message_id', 'user_id'];

    	
    	// Each MessageViewer belongs to a message
	public function message()
	{
		return $this->belongsTo(Message::class);
	}

    	// Each MessageViewer is a user
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
