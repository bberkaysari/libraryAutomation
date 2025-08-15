<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';  // Tablo adı

    protected $primaryKey = 'transaction_id';  // Primary key

    protected $fillable = [
        'reader_id',
        'kitap_id',
        'ıssiue_date',
        'due_date',
        'return_date',
    ];

    // Okuyucu ile ilişki
    public function reader(){
        return $this->belongsTo(Reader::class,'reader_id');
    }
    public function book(){
        return $this->belongsTo(Book::class,'kitap_id');
    }
}
