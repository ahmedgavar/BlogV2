<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Qirolab\Laravel\Reactions\Traits\Reactable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;

class Post extends Model implements ReactableInterface
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;
    use Reactable;

    protected $guarded = [];

    protected $dates=['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');

    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function post_Images(){
        return $this->hasMany(PostImages::class,'post_id');
    }


    public function sluggable():array{
        return [
            'slug'=>['source'=>'title']
        ];

    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
        static::updating(function ($model) {
            $model->user_id = Auth::id();
        });

    }


}
