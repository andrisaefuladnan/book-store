<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $buku_id = $_POST['buku_id'];
    $jumlah = $_POST['jumlah'];
    $total_harga = $_POST['total_harga'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // Simpan detail pesanan ke database
    $query = "INSERT INTO pesanan (buku_id, jumlah, total_harga, nama, alamat, no_hp) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Periksa apakah prepare() berhasil
    if ($stmt === false) {
        die('Error prepare: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("iiisss", $buku_id, $jumlah, $total_harga, $nama, $alamat, $no_hp);
    $stmt->execute();

    // Dapatkan ID pesanan terakhir yang dimasukkan
    $pesanan_id = $stmt->insert_id;

    // Ambil detail buku
    $query_buku = "SELECT * FROM buku WHERE id = ?";
    $stmt_buku = $conn->prepare($query_buku);

    // Periksa apakah prepare() berhasil
    if ($stmt_buku === false) {
        die('Error prepare: ' . htmlspecialchars($conn->error));
    }

    $stmt_buku->bind_param("i", $buku_id);
    $stmt_buku->execute();
    $result_buku = $stmt_buku->get_result();
    $buku = $result_buku->fetch_assoc();
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
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
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Detail Pesanan</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Pesanan Anda</h5>
                <p class="card-text"><strong>Nama:</strong> <?php echo htmlspecialchars($nama); ?></p>
                <p class="card-text"><strong>Alamat:</strong> <?php echo htmlspecialchars($alamat); ?></p>
                <p class="card-text"><strong>No HP:</strong> <?php echo htmlspecialchars($no_hp); ?></p>
                <p class="card-text"><strong>Judul Buku:</strong> <?php echo htmlspecialchars($buku['judul']); ?></p>
                <p class="card-text"><strong>Jumlah:</strong> <?php echo htmlspecialchars($jumlah); ?></p>
                <p class="card-text"><strong>Total Harga:</strong> Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></p>
                <p class="card-text"><strong>ID Pesanan:</strong> <?php echo htmlspecialchars($pesanan_id); ?></p>
                <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
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