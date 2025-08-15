<!-- resources/views/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <!-- Header içerikleri burada yer alır -->
        <h1>Yazarlar</h1>
    </x-slot>

    <!-- Sayfa içeriği burada yer alır -->
    <div class="container">
        <h2>Yazarlar Listesi</h2>
        <ul>
            @foreach ($authors as $author)
                <li>{{ $author->author_nameSurname }}</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
