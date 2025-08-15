<x-app-layout>
    <x-slot name="header">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-custom" onclick="openModal()">Kitap Ekle</button>
            <button type="button" class="btn btn-custom" onclick="openAuthorModal()">Yazar Ekle</button>
            <button type="button" class="btn btn-custom" onclick="openCategoryModal()">Kategori Ekle</button>
            <button type="button" class="btn btn-custom" onclick="openReaderModal()">Okuyucu Ekle</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div id="transaction-buttons">
                        <!-- Butonlar Alt Alta Sıralanacak -->
                        <div class="my-4 d-flex justify-content-center align-items-center flex-column">
                            <!-- İşlem Yap Butonu -->
                            <a href="{{ route('transactions.create') }}" class="button button-primary">
                                İşlem Yap
                            </a>


                            <!-- Kitap Durumu Linki -->
                            <a href="javascript:void(0)" onclick="toogleModal()" class="button button-status">
                                Kitap Durumları
                            </a>
                        </div>
                    </div>

                    <!-- Kitapları Listele Modal -->
                    <div id="booksListModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="relative z-10 w-2/3 p-6 bg-white rounded-md">
                            <div class="flex items-center gap-4 mb-4"> <!-- Flex container ile başlık ve arama kutusu arasında boşluk bırakıyoruz -->
                                <h3 class="text-xl font-semibold">Kitaplar Listesi</h3>

                                <!-- Arama Kutusu -->
                                <form class="flex" onsubmit="return filterTable(event)">
                                    <input class="border-gray-300 rounded-md form-control" type="search" id="bookSearchInput"
                                        placeholder="Kitap Ara" aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit">Ara</button>
                                </form>
                            </div>
                        <div class="overflow-y-auto" style="max-height: 600px;">

                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Kitap Adı</th>
                                        <th class="px-4 py-2">Kategori</th>
                                        <th class="px-4 py-2">Yazar</th>
                                        <th class="px-4 py-2">Sayfa Sayısı</th>
                                        <th class="px-4 py-2">Durum</th>
                                    </tr>
                                </thead>
                                <tbody  >
                                    @foreach($books as $book)
                                    <tr class="book-row">
                                        <td class="px-4 py-2">{{ $book->kitap_ad }}</td>
                                        <!-- Kategori Adı -->
                                        <td class="px-4 py-2">{{ $book->category ? $book->category->category_name : 'Kategori Bilgisi Yok' }}</td>
                                        <td class="px-4 py-2">{{ $book->author ? $book->author->author_nameSurname : 'Yazar Bilgisi Yok' }}</td>
                                        <td class="px-4 py-2">{{ $book->page_count }}</td>
                                        <th class="px-4 py-2">Kimde</th>

                                        <td class="px-4 py-2">
                                            <!-- Durum yuvarlağı: yeşil (verildi) veya kırmızı (verilmedi) -->
                                            <span class="status-circle" data-book-id="{{ $book->kitap_id }}"
                                                style="background-color: {{ !$book->is_given ? '#28a745' : '#dc3545' }};">
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            @if($book->is_given)
                                                @php
                                                    // Kitap kütüphanede ise, en son yapılan işlemi (transaction) alıyoruz
                                                    $lastTransaction = $book->transactions()->latest()->first();
                                                @endphp
                                                {{ $lastTransaction && $lastTransaction->reader ? $lastTransaction->reader->reader_nameSurname : 'Bilgi Yok' }}
                                            @else
                                                {{-- Eğer kitap verilmişse, durumunuzu farklı biçimde gösterebilirsiniz --}}
                                                Kitap Şu Anda Verilebilir
                                            @endif
                                        </td>


                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                            <button onclick="toggleCloseModal()" class="px-4 py-2 mt-4 text-white bg-gray-500 rounded-md">
                                Kapat
                            </button>
                        </div>
                    </div>
                    <!-- Modal Kitap Ekle -->
                    <div id="modal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="relative z-10 w-1/3 p-6 bg-white rounded-md">
                            <h3 class="mb-4 text-xl font-semibold">Kitap Ekle</h3>
                            <form action="{{ route('books.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="kitap_ad" class="block text-sm font-medium">Kitap Adı:</label>
                                    <input type="text" id="kitap_ad" name="kitap_ad" class="w-full rounded-md" required>
                                </div>
                                <div class="mb-4">
                                    <label for="category_id" class="block text-sm font-medium">Kategori Adı:</label>
                                    <select id="category_id" name="category_id" class="w-full rounded-md">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-4">
                                    <label for="author_id" class="block text-sm font-medium">Yazar:</label>
                                    <select id="author_id" name="author_id" class="w-full rounded-md">
                                        @foreach($authors as $author)
                                            <option value="{{ $author->author_id }}">{{ $author->author_nameSurname }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="page_count" class="block text-sm font-medium">Sayfa Sayısı:</label>
                                    <input type="number" id="page_count" name="page_count" class="w-full rounded-md" required>
                                </div>

                                <button type="submit" class="px-4 py-2 text-white rounded-md" style="background-color: #FF5733;">
                                    Kaydet
                                </button>
                            </form>
                            <button onclick="closeModal()" class="px-4 py-2 mt-4 text-white bg-gray-500 rounded-md">
                                Kapat
                            </button>
                        </div>
                    </div>

                    <!-- Modal Yazar Ekle -->
                    <div id="author-modal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="relative z-10 w-1/3 p-6 bg-white rounded-md">
                            <h3 class="mb-4 text-xl font-semibold">Yazar Ekle</h3>
                            <form action="{{ route('authors.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="author_nameSurname" class="block text-sm font-medium">Yazar Adı Soyadı:</label>
                                    <input type="text" id="author_nameSurname" name="author_nameSurname" class="w-full rounded-md" required>
                                </div>

                                <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded-md" style="background-color: #FF5733">
                                    Kaydet
                                </button>
                            </form>
                            <button onclick="closeAuthorModal()" class="px-4 py-2 mt-4 text-white bg-gray-500 rounded-md">
                                Kapat
                            </button>
                        </div>
                    </div>
                    <!-- Modal Okuyucu Ekle -->
                    <div id="reader-modal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="relative z-10 w-1/3 p-6 bg-white rounded-md">
                            <h3 class="mb-4 text-xl font-semibold">Okuyucu Ekle</h3>
                            <form action="{{ route('readers.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="reader_nameSurname" class="block text-sm font-medium">Okuyucu Adı:</label>
                                    <input type="text" id="reader_nameSurname" name="reader_nameSurname" class="w-full rounded-md" required placeholder="Okuyucu Adı ve Soyadı">
                                </div>

                                <div class="mb-4">
                                    <label for="gender" class="block text-sm font-medium">Cinsiyet:</label>
                                    <select id="gender" name="gender" class="w-full rounded-md">
                                        <option value="1">Erkek</option>
                                        <option value="0">Kadın</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium">Email:</label>
                                    <input type="email" id="email" name="email" class="w-full rounded-md" required placeholder="Email">
                                </div>

                                <div class="mb-4">
                                    <label for="phone" class="block text-sm font-medium">Telefon:</label>
                                    <input type="text" id="phone" name="phone" class="w-full rounded-md" required placeholder="Telefon Numarası">
                                </div>

                                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md" style="background-color: #FF5733">
                                    Kaydet
                                </button>
                            </form>
                            <button onclick="closeReaderModal()" class="px-4 py-2 mt-4 text-white bg-gray-500 rounded-md">
                                Kapat
                            </button>
                        </div>
                    </div>

                    <!-- Modal Kategori Ekle -->
                    <div id="category-modal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="relative z-10 w-1/3 p-6 bg-white rounded-md">
                            <h3 class="mb-4 text-xl font-semibold">Kategori Ekle</h3>
                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="category_name" class="block text-sm font-medium">Kategori Adı:</label>
                                    <input type="text" id="category_name" name="category_name" class="w-full rounded-md" required>
                                </div>
                                <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded-md"  style="background-color: #FF5733">Kaydet</button>
                            </form>

                            <button onclick="closeCategoryModal()" class="px-4 py-2 mt-4 text-white bg-gray-500 rounded-md">
                                Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal için CSS -->
    <style>
        #booksTableBody {
            display: block;          /* Blok düzeyinde davranması için */
            max-height: 300px;        /* İhtiyaca göre maksimum yükseklik */
            overflow-y: auto;         /* Yalnızca dikey kaydırma çubuğu ekler */
        }
        /* Modal için z-index */
        #modal, #author-modal, #category-modal {
            z-index: 9999; /* Modal'ın en üstte olmasını sağlar */
        }

        /* Modal içerik kutusu */
        .w-1/3 {
            position: relative;
            z-index: 10000; /* Modal içerik kutusunun z-index'i, siyah arka planın önünde olmalı */
        }


        /* Sadece #transaction-buttons id'sine sahip div için geçerli stil */
        #transaction-buttons {
            display: flex;
            flex-direction: column; /* Butonları alt alta sıralar */
            align-items: center;
            margin-top: 20px;
            gap: 20px; /* Butonlar arasındaki mesafeyi belirler */
        }

        /* Buton Genel Stili */
        #transaction-buttons .button {
            display: block;
            width: 250px;
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        /* İşlem Yap Butonu */
        #transaction-buttons .button-primary {
            background-color: #b6d0eb;
            color: white;
        }

        #transaction-buttons .button-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Kitap Durumu Linki */
        #transaction-buttons .button-status {
            background-color: #28a745;
            color: white;
        }

        #transaction-buttons .button-status:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        #transaction-buttons .button-update {
            background-color: #749dc8;
            color: white;
        }

        #transaction-buttons .button-update:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .status-circle {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .status-circle:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .btn-custom {
            position: relative;
            transition: all 0.3s ease-in-out; /* Yumuşak geçiş */
            padding: 10px 20px;
            font-size: 16px;
            background-color: #6c757d; /* Buton rengi */
            color: white;
            border: none;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom:hover {
            transform: translateY(-5px); /* Üzerine gelince yukarı kaydırma */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Gölgeyi arttırma */
        }

        .btn-group {
            display: flex;
            gap: 10px; /* Butonlar arasındaki boşluk */
        }

    </style>

    <!-- JavaScript to open and close modal -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Arama fonksiyonu
        function filterTable(event) {
            event.preventDefault(); // Form gönderimini engelliyoruz

            let input = document.getElementById('bookSearchInput').value.toLowerCase(); // Arama input değeri
            let tableRows = document.querySelectorAll('.book-row'); // Tablodaki tüm satırlar

            tableRows.forEach(row => {
                let bookName = row.cells[0].innerText.toLowerCase(); // Kitap adı hücresindeki metni alıyoruz

                // Eğer kitap adı arama inputu ile uyuşuyorsa, satırı gösteriyoruz. Aksi takdirde gizliyoruz.
                row.style.display = bookName.includes(input) ? '' : 'none';
            });
        }
        // Modal İşlevleri
        function toogleModal() {
            document.getElementById('booksListModal').classList.remove('hidden'); // Modal'ı göster
        }

        function toggleCloseModal(){
            document.getElementById('booksListModal').classList.toggle('hidden');
        }

        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
        function openAuthorModal() {
            document.getElementById('author-modal').classList.remove('hidden');
        }
        function closeAuthorModal() {
            document.getElementById('author-modal').classList.add('hidden');
        }
        function openCategoryModal() {
            document.getElementById('category-modal').classList.remove('hidden');
        }
        function closeCategoryModal() {
            document.getElementById('category-modal').classList.add('hidden');
        }
        function openReaderModal() {
            document.getElementById('reader-modal').classList.remove('hidden');
        }
        function closeReaderModal() {
            document.getElementById('reader-modal').classList.add('hidden');
        }

        // AJAX ile Durum Değiştirme İşlemi
        $(document).ready(function() {
            $('.status-circle').on('click', function() {
                var $circle = $(this);
                var bookId = $circle.data('book-id');

                $.ajax({
                    url: '/books/' + bookId + '/toggle-status',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            // Durum güncellendiğinde yuvarlağın rengini güncelle
                            if(response.is_given) {
                                $circle.css('background-color', '#28a745'); // Yeşil: Kitap Müsait
                            } else {
                                $circle.css('background-color', '#dc3545'); // Kırmızı: Kitap Teslim Edilmedi
                            }
                        } else {
                            alert('Bir hata oluştu.');
                        }
                    },
                    error: function() {
                        alert('Sunucu ile bağlantı kurulamadı.');
                    }
                });
            });
        });
    </script>



</x-app-layout>
