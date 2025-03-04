<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('images')->when($request->search, function ($query, $search) {
            return $query->where('title', 'like', "%$search%");
        })->paginate(10);

        return BookResource::collection($books);
    }
}
