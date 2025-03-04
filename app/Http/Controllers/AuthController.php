<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\BookRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($request->hasFile('avatar')) {
            $path = $this->uploadFile($request->file('avatar'), 'avatars');
            $user->avatar()->create(['path' => $path]);
        }

        return new UserResource($user);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => Auth::user()->createToken('authToken')->plainTextToken]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();
        $book = Book::create($data);
        return new BookResource($book);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(BookRequest $request, Book $book)
    {
        $data = $request->validated();
        $book->update($data);
        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }
}
