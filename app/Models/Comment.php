<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Qirolab\Laravel\Reactions\Traits\Reactable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;

class Comment extends Model implements ReactableInterface
{
    use HasFactory,Reactable;

protected $guarded=['id'];

public function user()
{
    return $this->belongsTo(User::class);
}
public function post()
{
    return $this->belongsTo(Post::class);
}

}
