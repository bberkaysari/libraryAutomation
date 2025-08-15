<?php

namespace App\Http\Controllers;

use App\Mail\BookTransactionMail;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\Reader;
use App\Models\Book;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    //
    public function index(){
        $transactions = Transactions::with(['reader', 'book'])->get();
        return view('transactions.index',compact('transactions'));
    }
    public function create(Request $request){
        $readers = Reader::all();
        $books= Book::where('is_given',false)->get();//yalnızca uygun kitapları getir
        return view('transactions.create', compact('readers', 'books'));

    }
    //Yeni transaction kaydını veri tabanına ekleme
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reader_id' => 'required|exists:readers,reader_id',
            'kitap_id' => 'required|exists:books,kitap_id',
            'ıssiue_date' => 'required|date',
            'due_date' => 'required|date|after:ıssiue_date',
            'return_date' => 'nullable|date',
        ]);
        //işlem yapılacak kitabı yazıyoruz
        $book =Book::findOrFail($validated['kitap_id']);
        //Eğer henüz kitap verilmemişse yeni işlem oluştur ve kitabı verildi olarak işaretle
        if(!$book->is_given){
            $transactions=Transactions::create($validated);
            $book->is_given = true;
            $book->save();
            $transactions->save($validated);
            $reader=Reader::findOrFail($validated['reader_id']);


            Mail::to($reader->email)->send(new BookTransactionMail(
                $reader->reader_nameSurname,
                $book->kitap_ad,
                $validated['ıssiue_date'],
                $validated['due_date']
            ));

            return redirect()->back()->with('success','İşlem başarıyla eklendi');

        }else{
            $existingTransaction=Transactions::where('kitap_id',$validated['kitap_id'])->latest()->first();
            //Eğer aynı okuyucuya ait işlem varsa,mevcut işlemi güncelliyoruz
            if($existingTransaction && $existingTransaction->reader_id == $validated['reader_id']){
                $existingTransaction->update($validated);
                return redirect()->back()->with('success','İşlem başarıyla güncellendi');
            }else{
                // Eğer kitap, farklı bir okuyucuya verildiyse,
                // eski işlem silinmeden yeni bir işlem oluşturuyoruz.
                $transactions=Transactions::create($validated);
                $transactions->save();
                // Kitap durumu zaten true kalıyor.
                return redirect()->back()->with('success', 'Yeni işlem başarıyla oluşturuldu.');
            }
        }
        /*Transactions::create($validated);
        $transactions = Transactions::create($validated);
        $transactions->save();

        // Kitap durumunu güncelle
        Book::where('kitap_id', $validated['kitap_id'])->update(['is_given' => true]);

        // Verilerin başarıyla eklendiğini bildiren mesajla yönlendir
        return redirect()->back()->with('success', 'İşlem başarıyla eklendi.');*/

    }


    //Belirli bir transaction detayını görüntüle
    public function show($id){
        //Transaction ile ilişkili reader/book verilerin al
        $transaction = Transactions::with(['reader', 'book'])->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }
    //Belirli bir transaction kaydını düzenleme sayfasını göster
    public function edit($id){
        // Transaction kaydını bul
        $transaction = Transactions::findOrFail($id);  // Burada transaction'ı alıyoruz
        $readers = Reader::all();
        $books = Book::where('is_given', 'false')->orWhere('kitap_id', $transaction->kitap_id)->get();
        return view('transactions.edit', compact('transaction', 'readers', 'books'));  // $transaction'ı view'e aktarıyoruz
    }


    //Transaction kaydını güncelleme
    public function update(Request $request, $id){
        $validated = $request->validate([
            'reader_id' => 'required|exists:readers,reader_id',
            'kitap_id' => 'required|exists:books,kitap_id',
            'ıssiue_date' => 'required|date',
            'due_date' => 'required|date|after:ıssiue_date',
            'return_date' => 'nullable|date',
        ]);
        //Belirli bir transactions kaydını bul
        $transaction = Transactions::findOrFail($id);
        //Kitap durumunu güncelle
        if ($transaction->kitap_id != $validated['kitap_id']) {
            Book::where('kitap_id', $transaction->kitap_id)->update(['is_given' => false]);
            Book::where('kitap_id', $validated['kitap_id'])->update(['is_given' => true]);
        }
        //Transaction kaydını güncelle
        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'İşlem başarıyla güncellendi.');
    }
    //Transaction kaydını silme
    public function destroy($id){
        $transaction = Transactions::findOrFail($id);
        //Kitap durumunu güncelle
        Book::where('kitap_id', $transaction->kitap_id)->update(['is_given' => false]);
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success','İşlem başarıyla silindi.');

    }
}