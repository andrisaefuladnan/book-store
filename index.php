<?php
include 'db.php';

// Query untuk mendapatkan daftar buku dengan urutan terbaru di bagian atas
$query_buku = "SELECT buku.*, kategori.nama AS kategori_nama FROM buku LEFT JOIN kategori ON buku.kategori_id = kategori.id ORDER BY buku.id DESC";
$result_buku = mysqli_query($conn, $query_buku);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
            box-shadow: 0 4px 6px -6px #222;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff !important;
        }
        .nav-link {
            font-size: 1rem;
            color: #007bff !important;
        }
        .nav-link:hover {
            color: #0056b3 !important;
        }
        .thumbnail {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem;
        }
        .price {
            font-size: 1.1rem;
            color: #007bff;
            font-weight: bold;
        }
        .btn-buy {
            background-color: #007bff;
            color: white;
        }
        .btn-buy:hover {
            background-color: #0056b3;
            color: white;
        }
        footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e7e7e7;
        }
        footer p {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Book Store</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4 text-center">Daftar Buku</h1>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result_buku)) { ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img src="images/<?php echo $row['image']; ?>" class="card-img-top thumbnail" alt="<?php echo $row['judul']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                            <p class="card-text"><?php echo substr($row['sinopsis'], 0, 100); ?>...</p>
                            <p class="price">Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                            <a href="purchase.php?id=<?php echo $row['id']; ?>" class="btn btn-buy">Beli</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <footer class="text-center mt-5 py-4 bg-light">
        <p>&copy; 2025 Book Store. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>