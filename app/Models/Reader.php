<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    use HasFactory;

    protected $table = "readers";
    protected $primaryKey = 'reader_id'; // Doğru bir primary key adı
    protected $fillable = [
        'reader_nameSurname',
        'gender',
        'email',
        'phone',
    ];

    // Many-to-Many İlişkisi
    public function books()
    {
        return $this->belongsToMany(Book::class, 'transactions', 'reader_id', 'kitap_id')
            ->withPivot('ıssiue_date', 'due_date', 'return_date');
    }
}