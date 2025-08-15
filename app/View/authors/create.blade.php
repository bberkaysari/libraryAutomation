<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kitap Ekle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf

                        <!-- Kitap Adı -->
                        <div class="mb-4">
                            <label for="kitap_ad" class="block text-sm font-medium">Kitap Adı:</label>
                            <input type="text" id="kitap_ad" name="kitap_ad" class="w-full rounded-md" required>
                        </div>

                        <!-- Yazar Seçimi -->
                        <div class="mb-4">
                            <label for="author_id" class="block text-sm font-medium">Yazar:</label>
                            <select id="author_id" name="author_id" class="w-full rounded-md" required>
                                <option value="">Yazar Seçiniz</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->author_id }}">{{ $author->author_nameSurname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kategori Seçimi -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium">Kategori:</label>
                            <select id="category_id" name="category_id" class="w-full rounded-md" required>
                                <option value="">Kategori Seçiniz</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sayfa Sayısı -->
                        <div class="mb-4">
                            <label for="page_count" class="block text-sm font-medium">Sayfa Sayısı:</label>
                            <input type="number" id="page_count" name="page_count" class="w-full rounded-md" required>
                        </div>

                        <!-- Kaydet Butonu -->
                        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md">
                            Kaydet
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
