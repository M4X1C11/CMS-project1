<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Polja koja se mogu masovno popunjavati
    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'status',
        'category_id', // dodato za kategoriju
    ];

    // Veza ka korisniku koji je kreirao post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Veza ka kategoriji
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Veza ka tagovima
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function comments()
{
    return $this->hasMany(Comment::class);
}

}
