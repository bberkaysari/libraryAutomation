<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
// Corrected CategoriesController
    public function index()
    {
        $categories = Categories::all();  // Tüm kategorileri al
        return view('categories', compact('categories'));  // Veriyi view'a aktar
    }


    public function show($id)
    {
        $category = Categories::findOrFail($id);  // Kategoriyi bul
        $books = $category->books;  // Kategorinin kitaplarını al
        return view('categories.show', compact('category', 'books'));  // Doğru isimlendirme
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        // Yeni kategori kaydını veritabanına ekle
        $category = new Categories();
        $category->category_name = $request->category_name;  // 'category_name' kullanın
        $category->save();

        // Başarı mesajı ile yönlendirme
        return redirect()->route('categories.index')->with('success', 'Kategori Başarıyla Eklendi.');
    }



}
