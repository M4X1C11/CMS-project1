<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Polja koja se mogu masovno popunjavati
    protected $fillable = [
        'name',
        'slug',
    ];

    // Veza ka postovima (pivot tabela post_tag)
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
