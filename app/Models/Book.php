<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'description',
        'published_year',
        'stock',
    ];

    // Belongs to Author
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    // Belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Many to Many — Book belongs to many Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // One to Many — Book has many Borrowings
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}