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
        $query->when($filters ?? false, function($query, $search)
        {
            return $query->where('id', 'like', '%'.$search.'%');
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
