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

    public function edit(Borrowing $borrowing)
    {
        $books = Book::all();
        $members = Member::all();
        return view('borrowings.edit', compact('borrowing', 'books', 'members'));
    }

     public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'book_id'       => 'required|exists:books,id',
            'member_id'     => 'required|exists:members,id',
            'borrowed_date' => 'required|date',
            'return_date'   => 'nullable|date|after:borrowed_date',
            'status'        => 'required|in:borrowed,returned,overdue',
        ]);

        // If status changed to returned, increase stock back
        if ($request->status == 'returned' && $borrowing->status != 'returned') {
            $borrowing->book->increment('stock');
        }

        $borrowing->update($request->all());

        return redirect()->route('borrowings.index')
            ->with('success', 'Borrowing record updated successfully!');
    }

     public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();

        return redirect()->route('borrowings.index')
            ->with('success', 'Borrowing record deleted successfully!');
    }

}