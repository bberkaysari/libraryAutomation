<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Reader;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    //
    public function index(Request $request)
    {
        // Tüm okurları al
        $readers = Reader::all();

        // Okurların kitaplarını al (her reader için ilgili kitaplar)
        $books = $readers->flatMap(function ($reader) {
            return $reader->books;
        });

        // Veriyi 'readerindex' view'ına aktar
        return view('readerindex', compact('readers', 'books'));
    }

    public function show($id){
        $reader = Reader::findOrFail($id); //okuyucuyu bul
        $books = $reader->books;  // okuyucunun kitapları

        return view('readers.show', compact('reader', 'books'));
    }


    public function store(Request $request){
        $validated= $request->validate([
            'reader_nameSurname' => 'required|string|max:255',
            'gender' => 'required|boolean',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',

        ]);
        $reader = Reader::create($validated);
        $reader->save();
        return redirect()->back()->with('success', 'Okuyucu başarıyla eklendi.');


    }

}
