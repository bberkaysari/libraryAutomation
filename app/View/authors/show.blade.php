@extends('layouts.app')

@section('content')
    <div>
        <h1>{{ $author->author_nameSurname }}'ın Kitapları</h1>
        <ul>
            @foreach ($books as $book)
                <li>{{ $book->kitap_ad }}</li>
            @endforeach
        </ul>
    </div>
@endsection
