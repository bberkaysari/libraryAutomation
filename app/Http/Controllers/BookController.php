<?php

// app/Http/Controllers/BookController.php
// app/Http/Controllers/BookController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Categories;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function create()
    {
        // Yazarları ve kategorileri al
        $authors = Author::all();
        $categories = Categories::all();

        // Yazarlar ve kategorilerle birlikte kitap ekleme sayfasını döndür
        return view('create', compact('authors', 'categories'));
    }
    public function store(Request $request)
    {
        // Form verilerini doğrulama
        $request->validate([
            'kitap_ad' => 'required|string|max:100',
            'author_id' => 'nullable|exists:authors,author_id',
            'page_count' => 'required|integer|min:1',
            'category_id' => 'nullable|exists:categories,category_id',
        ]);

        // Kitap verisini veritabanına kaydet
        Book::create([
            'kitap_ad' => $request->kitap_ad,
            'author_id' => $request->author_id,
            'page_count' => $request->page_count,
            'category_id' => $request->category_id,
        ]);

        // Başarı mesajı ile yönlendir
        return redirect()->back()->with('success', 'Kitap başarıyla eklendi.');
    }
    public function index()
    {
        $books = Book::with(['category', 'author', 'transactions'])->get(); // transactions ilişkisinin tamamı yüklenecek

        return view('index', compact('books'));
    }
    public function toggleStatus($id)
    {
        $book = Book::findOrFail($id);
        Log::info("toggleStatus çağrıldı. Kitap ID: $id, mevcut is_given: " . $book->is_given);

        $book->is_given = !$book->is_given;
        $saved = $book->save();
        $book->refresh(); // Güncel veriyi yeniden yükle

        Log::info("Güncelleme " . ($saved ? "başarılı" : "başarısız") . ". Yeni is_given: " . $book->is_given);

        return response()->json([
            'success'  => $saved,
            'is_given' => $book->is_given,
        ]);
    }


}