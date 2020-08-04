<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";

    protected $fillable = ['title', 'tags', 'description'];

    public function scopeSearch($query, $search='')
    {
        if (empty($search)) {
            return $query;
        } else {
            return $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('tags', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('admin', function ($query) use($search){
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('admin', function ($query) use($search){
                        $query->where('email', '=', $search );
                    });
        }
    }

    public function scopeFilter($query, $filters=array())
    {
        if(isset($filters['month'])){
            $query = $query->whereMonth('created_at', Carbon::parse($filters['month'])->month);
        }
        if(isset($filters['year'])){
            $query = $query->whereYear('created_at', $filters['year']);
        }
        return $query;
    }

    public static function archives()
    {
        return static::selectRaw('year(created_at) year, monthname(created_at) month')->where('status', '<>', 0)->orderByRaw('min(created_at) desc')->groupBy('year', 'month')->get();
    }

    public static function allTags()
    {
        $all_tags = '';
        $get_tags = static::select('tags')->where('status', '<>', 0)->get()->toArray();
        for($i=0; $i<count($get_tags); $i++){
            $all_tags .= $get_tags[$i]['tags'].',';
        }
        $all_tags = explode(',', $all_tags);
        return array_filter(array_unique($all_tags));
    }
    	
    	// Each news belongs to a admin
	public function admin()
	{
		return $this->belongsTo(Admin::class);
	}
}
