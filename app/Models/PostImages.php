<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImages extends Model
{
    protected $guarded = [];

    use HasFactory;
    public function post(){
        return $this->hasMany(PostImages::class);
    }
}
