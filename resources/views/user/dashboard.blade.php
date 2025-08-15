@extends('layouts.user')

@section('content')
    <div class="container">
        <h1>Kullanıcı Paneli</h1>
        <p>Hoşgeldiniz, {{ $user->name }}!</p>
    </div>
@endsection
