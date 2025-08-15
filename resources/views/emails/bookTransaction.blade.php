<!DOCTYPE html>
<html>
<body>
    <h2>Sayın {{ $readerName }},</h2>
    <p>Kitap işleminiz başarıyla gerçekleşmiştir.</p>
    <p><strong>Kitap Adı:</strong> {{ $bookName }}</p>
    <p><strong>Alım Tarihi:</strong> {{ $issueDate }}</p>
    <p><strong>Son Teslim Tarihi:</strong> {{ $dueDate }}</p>
    <p>Lütfen son teslim tarihine dikkat ediniz.Gecikmesi durumunda tekrardan kitap verilmeyecektir.</p>
    <p>Kütüphanemizi tercih ettiğiniz için teşekkür ederiz!</p>
</body>
</html>
