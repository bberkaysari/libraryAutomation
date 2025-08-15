<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $primaryKey = 'kitap_id';

    protected $fillable = ['kitap_ad', 'author_id', 'page_count', 'category_id', 'is_given'];

    public function author(){
        return $this->belongsTo(Author::class, 'author_id', 'author_id');
    }

    public function category(){
        return $this->belongsTo(Categories::class, 'category_id', 'category_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function transactions(){
        return $this->hasMany(Transactions::class, 'kitap_id', 'kitap_id');
    }

}
