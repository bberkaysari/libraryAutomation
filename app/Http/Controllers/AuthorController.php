<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();  // Tüm yazarları al
        return view('index', compact('authors'));  // Veriyi view'a aktar
    }


    public function show($id)
    {
        $author = Author::findOrFail($id);
        $books = $author->books;  // Yazarın kitapları

        return view('authors.show', compact('author', 'books'));
    }
    public function store(Request $request)
    {
        // Form verilerinin doğrulama işlemi
        $validated = $request->validate([
            'author_nameSurname' => 'required|string|max:255',
        ]);

        // Yeni yazar kaydını veritabanına ekle
        $author = new Author();
        $author->author_nameSurname = $request->author_nameSurname;
        $author->save();  // Veritabanına kaydet

        // Yazar ekleme işlemi başarıyla tamamlandığında yönlendirme
        return redirect()->route('authors.index')->with('success', 'Yazar başarıyla eklendi.');
    }
}
