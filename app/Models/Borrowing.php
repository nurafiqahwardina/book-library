<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'book_id',
        'borrowed_date',
        'return_date',
        'status',
    ];

    // Belongs to Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Belongs to Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}