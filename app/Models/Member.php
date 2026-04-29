<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    // One to Many — Member has many Borrowings
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}