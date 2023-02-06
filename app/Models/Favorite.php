<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search)
        {
            return $query->where('id', 'like', '%'.$search.'%');
        });

        $query->when($filters['username'] ?? false, function($query, $username){
            return $query->whereHas('user', function($query) use ($username){
                $query->where('username', $username);
            });
        });

        $query->when($filters['content'] ?? false, function($query, $content){
            return $query->whereHas('content', function($query) use ($content){
                $query->where('id', $content);
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function content()
    {
        return $this->belongsTo(Content::class);
    }
    public function discuss()
    {
        return $this->belongsTo(Discuss::class);
    }
}
