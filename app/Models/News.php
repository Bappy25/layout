<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";

    protected $fillable = ['title', 'tags', 'image_path', 'description'];

    public function scopeSearch($query, $search='')
    {
        if (empty($search)) {
            return $query;
        } else {
            /*return $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('username', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('user_detail', function ($query) use($search){
                        $query->where('address', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('user_detail', function ($query) use($search){
                        $query->where('contact', '=', $search );
                    });*/
        }
    }
    	
    	// Each news belongs to a admin
	public function admin()
	{
		return $this->belongsTo(Admin::class);
	}
}
