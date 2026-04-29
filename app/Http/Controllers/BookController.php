<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Tag;


class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'category', 'tags'])->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        $tags = Tag::all();
        return view('books.create', compact('authors', 'categories', 'tags'));
    }

}