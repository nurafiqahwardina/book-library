<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->paginate(10);
        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio'  => 'nullable|string',
        ]);

        Author::create($request->only('name', 'bio'));

        return redirect()->route('authors.index')
            ->with('success', 'Author added successfully!');
    }

    public function show(Author $author)
    {
        $books = $author->books()->with('category')->get();
        $author->loadCount('books');
        //$author->load('books.category');
        return view('authors.show', compact('author', 'books'));
    }   


}