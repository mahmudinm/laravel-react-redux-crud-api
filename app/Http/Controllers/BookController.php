<?php

namespace App\Http\Controllers;

use File;
use App\Book;
use App\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
    
    public function index()
    {
        $books = Book::all();
        $books->load('author');
        return response()->json($books);
    }

    public function create()
    {
        $authors = Author::select('id', 'first_name', 'last_name')->get();
        return response()->json($authors);
    }

    // Untuk request post dengan postman pastikan gunakan content-type application/json dan accept json
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'author_id' => 'required',
            // 'image' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required'
        ]);

        $existFile = '';
        if ($request->file('image')) {
            $file = $request->file('image');
            $namaFile = time()."_".$file->getClientOriginalName();
            $tujuanUpload = public_path().'/image';
            $file->move($tujuanUpload, $namaFile);
            $existFile .= $namaFile;
        }

        $book = new Book;
        $book->create($request->except('image') + [
            'image' => $existFile
        ]);

        return response()->json('Success', 201);
    }

    public function show(Book $book)
    {
        return response()->json($book);
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        // $book->load('author');
        return response()->json([$authors, $book]);
    }

    // untuk request update put ataupun patch pastikan methodnya post dan tambahkan field _method: (put, patch atau delete)
    public function update(Request $request, Book $book)
    {
        $this->validate($request, [
            'name' => 'required',
            'author_id' => 'required',
            'category' => 'required'
        ]);

        if ($request->file('image')) {
            if ($book->image) {
                $imageExist = public_path("image/{$book->image}");
                if (File::exists($imageExist)) {
                    unlink($imageExist);
                }
            }

            $file = $request->file('image');
            $namaFile = time()."_".$file->getClientOriginalName();
            $tujuanUpload = public_path().'/image';
            $file->move($tujuanUpload, $namaFile);

            $book->image = $namaFile;
        }

        $book->name = $request->name;
        $book->author_id = $request->author_id;
        $book->category = $request->category;
        $book->save();

        // $book->update($request->all());
        return response()->json('Success', 201); 
    }
    
    // untuk request update put ataupun patch pastikan methodnya post dan tambahkan field _method: (put, patch atau delete)
    public function destroy(Book $book)
    {
        if ($book->image) {
            $imageExist = public_path("image/{$book->image}");
            if (File::exists($imageExist)) {
                unlink($imageExist);
            }
        }
        $book->delete();
        return response()->json('Success', 201);        
    }
}
