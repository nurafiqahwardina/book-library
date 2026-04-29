<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;


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
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'author_id'      => 'required|exists:authors,id',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'published_year' => 'nullable|digits:4|integer',
            'stock'          => 'required|integer|min:0',
            'tags'           => 'nullable|array',
        ]);

        $book = Book::create($request->except('tags'));

        if ($request->has('tags')) {
            $book->tags()->attach($request->tags);
        }

        return redirect()->route('books.index')
            ->with('success', 'Book added successfully!');
    }

    public function show($id)
    {
        $book = Book::with(['author', 'category', 'tags'])->findOrFail($id);
        return view('books.show', compact('book'));
    }   

}