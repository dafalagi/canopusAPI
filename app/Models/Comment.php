<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters ?? false, function($query, $search)
        {
            return $query->where('id', 'like', '%'.$search.'%')
                         ->orWhere('body', 'like', '%'.$search.'%');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function discuss()
    {
        return $this->belongsTo(Discuss::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
