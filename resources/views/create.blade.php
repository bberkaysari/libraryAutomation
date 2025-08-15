<!-- resources/views/books/create.blade.php -->
<form action="{{ route('books.store') }}" method="POST">
    <!-- Modal for Adding Book -->
    <div id="modal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50">
        <div class="relative z-10 w-full max-w-lg p-6 bg-white rounded-md shadow-lg">
            <h3 class="mb-4 text-xl font-semibold text-gray-800">Kitap Ekle</h3>
            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                <!-- Kitap Adı -->
                <div class="mb-4">
                    <label for="kitap_ad" class="block text-sm font-medium text-gray-700">Kitap Adı:</label>
                    <input type="text" id="kitap_ad" name="kitap_ad" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Kategori Seçimi -->
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori Adı:</label>
                    <select id="category_id" name="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Yazar Seçimi -->
                <div class="mb-4">
                    <label for="author_id" class="block text-sm font-medium text-gray-700">Yazar:</label>
                    <select id="author_id" name="author_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach($authors as $author)
                            <option value="{{ $author->author_id }}">{{ $author->author_nameSurname }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sayfa Sayısı -->
                <div class="mb-4">
                    <label for="page_count" class="block text-sm font-medium text-gray-700">Sayfa Sayısı:</label>
                    <input type="number" id="page_count" name="page_count" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <!-- Submit Butonu -->
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 rounded-md shadow-sm hover:bg-blue-600">
                    Kaydet
                </button>
            </form>

            <!-- Kapat Butonu -->
            <button onclick="closeModal()" class="w-full px-4 py-2 mt-4 text-white bg-gray-500 rounded-md hover:bg-gray-600">
                Kapat
            </button>
        </div>
    </div>

</form>
