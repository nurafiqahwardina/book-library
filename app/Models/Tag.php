<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Many to Many — Tag belongs to many Books
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}