<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    // Untuk request post dengan postman pastikan gunakan content-type application/json dan accept json
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'author' => 'required',
            'category' => 'required'
        ]);

        Book::create($request->all());
        return response()->json('Success', 201);
    }

    public function show(Book $book)
    {
        return response()->json($book);
    }

    // untuk request update put ataupun patch pastikan methodnya post dan tambahkan field _method: (put, patch atau delete)
    public function update(Request $request, Book $book)
    {
        $this->validate($request, [
            'name' => 'required',
            'author' => 'required',
            'category' => 'required'
        ]);

        $book->update($request->all());
        return response()->json('Success', 201); 
    }

    
    // untuk request update put ataupun patch pastikan methodnya post dan tambahkan field _method: (put, patch atau delete)
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json('Success', 201);        
    }
}
