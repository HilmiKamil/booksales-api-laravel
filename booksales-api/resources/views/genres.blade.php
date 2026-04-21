<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Genre</title>
</head>
<body>
    <h2>Ini adalah Halaman Genre dari Booksales</h2>
    <h3>Daftar Genre</h3>
    @foreach ($genres as $item)
    <ul>
        <li><strong>Nama:</strong> {{ $item['name'] }}</li>
        <li><strong>Deskripsi:</strong> {{ $item['description'] }}</li>
    </ul>
@endforeach
</body>
</html>