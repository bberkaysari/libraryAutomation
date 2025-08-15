<!-- resources/views/transactions/create.blade.php -->
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni İşlem Ekle</title>
    <!-- Tailwind CSS CDN (isteğe bağlı, kendi stil dosyanızı da ekleyebilirsiniz) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <div id="islem-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-1/3 p-6 bg-white rounded-md shadow-lg">
            <h3 class="mb-4 text-xl font-semibold">Yeni İşlem Ekle</h3>
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reader_id" class="block text-sm font-medium">Okuyucu:</label>
                    <select name="reader_id" id="reader_id" class="w-full p-2 border border-gray-300 rounded-md">
                        @foreach ($readers as $reader)
                            <option value="{{ $reader->reader_id }}">{{ $reader->reader_nameSurname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="kitap_id" class="block text-sm font-medium">Kitap:</label>
                    <select name="kitap_id" id="kitap_id" class="w-full p-2 border border-gray-300 rounded-md">
                        @foreach ($books as $book)
                            <option value="{{ $book->kitap_id }}">{{ $book->kitap_ad }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="ıssiue_date" class="block text-sm font-medium">Veriliş Tarihi:</label>
                    <input type="date" name="ıssiue_date" id="ıssiue_date" class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium">Son Teslim Tarihi:</label>
                    <input type="date" name="due_date" id="due_date" class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="return_date" class="block text-sm font-medium">Getirdiği Tarih:</label>
                    <input type="date" name="return_date" id="return_date" class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <button type="submit" class="w-full py-2 text-white bg-blue-500 rounded-md">
                    Ekle
                </button>
            </form>
            <button onclick="closeModal()" class="w-full py-2 mt-4 text-white bg-gray-500 rounded-md">
                Kapat
            </button>
        </div>
    </div>

    <!-- Modal Kapatma İşlevi -->
    <script>
        function closeModal() {
            window.location.href = "{{ route('dashboard') }}";
        }
    </script>
</body>
</html>
