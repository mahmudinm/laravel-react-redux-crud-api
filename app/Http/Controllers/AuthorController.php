<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors);
    }

    // Untuk request post dengan postman pastikan gunakan content-type application/json dan accept json
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'handphone' => 'required'
        ]);

        Author::create($request->all());
        return response()->json('Success', 201);
    }

    public function edit(Author $author)
    {
        return response()->json($author);
    }

    // untuk request update put ataupun patch pastikan methodnya post dan tambahkan field _method: (put, patch atau delete)
    public function update(Request $request, Author $author)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'handphone' => 'required'
        ]);

        $author->update($request->all());
        return response()->json('Success', 201); 
    }

    
    // untuk request update put ataupun patch pastikan methodnya post dan tambahkan field _method: (put, patch atau delete)
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json('Success', 201);        
    }
}
