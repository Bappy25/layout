<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";

    protected $fillable = ['title', 'tags', 'description'];
    	
    	// Each news belongs to a admin
	public function admin()
	{
		return $this->belongsTo(Admin::class);
	}
}
