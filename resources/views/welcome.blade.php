<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Furnitur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .product-card {
            margin-bottom: 30px;
        }
        .product-card img {
            max-width: 100%;
            height: auto;
        }
        .product-card .product-info {
            padding: 10px;
        }
    </style>
</head>
<body>

    <header class="bg-primary text-white text-center py-5">
        <h1>Selamat Datang di Toko Furnitur</h1>
        <p>Temukan furnitur terbaik untuk rumah Anda</p>
    </header>

    <section class="container my-5">
        <div class="row">
            @foreach($barangs as $barang)
                <div class="col-md-4">
                    <div class="card product-card">
                        {{-- {{dd($barang->gambar)}} --}}
                        @if($barang->gambars && $barang->gambars->isNotEmpty())
                            @foreach($barang->gambars as $gambar)
                                <img src="{{ Storage::disk('public')->url($gambar->path) }}" alt="{{ $gambar->name }}">
                            @endforeach
                        @else
                            <img src="https://via.placeholder.com/350" alt="Image Not Available">
                        @endif
                        <div class="product-info">
                            <h5>{{ $barang->nama }}</h5>
                            <p>{{ $barang->deskripsi }}</p>
                            <p><strong>Price:</strong> ${{ $barang->harga }}</p>
                            <p><strong>Status:</strong> {{ $barang->stok }}</p>
                        </div>
                    </div> 
                </div>
            @endforeach
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Toko Furnitur. All rights reserved.</p>
    </footer>

</body>
</html>
