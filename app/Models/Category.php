<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Polja koja se mogu masovno popunjavati
    protected $fillable = [
        'name',
        'slug',
    ];

    // Veza ka postovima
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
