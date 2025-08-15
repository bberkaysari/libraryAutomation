@extends('layouts.app')

@section('content')
    <div>
        <h1>Yazarlar</h1>
        <ul>
            @foreach ($authors as $author)
                <li><a href="{{ route('authors.show', $author->author_id) }}">{{ $author->author_nameSurname }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection
