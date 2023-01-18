<?php

namespace App\Models;

use App\Enums\ContentCategory;
use App\Enums\ContentEvent;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $casts = [
        'pictures' => 'array',
        'event' => ContentEvent::class,
        'category' => ContentCategory::class,
    ];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters ?? false, function($query, $search)
        {
            return $query->where('title', 'like', '%'.$search.'%')
                         ->orWhere('intro', 'like', '%'.$search.'%')
                         ->orWhere('history', 'like', '%'.$search.'%');
        });
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
