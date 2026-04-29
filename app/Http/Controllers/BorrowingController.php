<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'member'])->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $books = Book::where('stock', '>', 0)->get();
        $members = Member::all();
        // dd($books, $members);
        // dd($books);
        return view('borrowings.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id'       => 'required|exists:books,id',
            'member_id'     => 'required|exists:members,id',
            'borrowed_date' => 'required|date',
            'return_date'   => 'nullable|date|after:borrowed_date',
            'status'        => 'required|in:borrowed,returned,overdue',
        ]);

        Borrowing::create($request->all());

        // Reduce stock by 1
        $book = Book::find($request->book_id);
        $book->decrement('stock');

        return redirect()->route('borrowings.index')
            ->with('success', 'Borrowing record added successfully!');
    }

    public function show($id)
    {
        $borrowing = Borrowing::with(['book', 'member'])->findOrFail($id);
        return view('borrowings.show', compact('borrowing'));
    }   

}