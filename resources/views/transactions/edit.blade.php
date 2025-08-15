@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>İşlem Güncelle</h1>

        <!-- Başarı mesajı -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Güncelleme Formu -->
        <form action="{{ route('transactions.update', $transaction->transaction_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="reader_id">Okuyucu Seçin</label>
                <select name="reader_id" id="reader_id" class="form-control">
                    @foreach($readers as $reader)
                        <option value="{{ $reader->reader_id }}"
                            {{ $transaction->reader_id == $reader->reader_id ? 'selected' : '' }}>
                            {{ $reader->name }}
                        </option>
                    @endforeach
                </select>
                @error('reader_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kitap_id">Kitap Seçin</label>
                <select name="kitap_id" id="kitap_id" class="form-control">
                    @foreach($books as $book)
                        <option value="{{ $book->kitap_id }}"
                            {{ $transaction->kitap_id == $book->kitap_id ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
                @error('kitap_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ıssiue_date">Alım Tarihi</label>
                <input type="date" name="ıssiue_date" id="ıssiue_date" class="form-control"
                    value="{{ old('ıssiue_date', $transaction->ıssiue_date) }}">
                @error('ıssiue_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="due_date">Teslim Tarihi</label>
                <input type="date" name="due_date" id="due_date" class="form-control"
                    value="{{ old('due_date', $transaction->due_date) }}">
                @error('due_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="return_date">İade Tarihi (Opsiyonel)</label>
                <input type="date" name="return_date" id="return_date" class="form-control"
                    value="{{ old('return_date', $transaction->return_date) }}">
                @error('return_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Güncelle</button>
        </form>
    </div>
@endsection
