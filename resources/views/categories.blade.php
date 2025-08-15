<x-app-layout>
    <x-slot name="header">
        <h1>Kategoriler</h1>
    </x-slot>

    <div class="container">
        <h2>Kategori Listesi</h2>
        <ul>
            @foreach ($categories as $category)
                <li>{{ $category->category_name }}</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
