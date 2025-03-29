<?php
include 'db.php';

// Mendapatkan ID pesanan dari URL
$pesanan_id = $_GET['id'];

// Query untuk mendapatkan detail pesanan
$query = "SELECT * FROM pemesanan WHERE id = $pesanan_id";
$result = mysqli_query($conn, $query);
$pesanan = mysqli_fetch_assoc($result);

// Query untuk mendapatkan detail buku
$query_buku = "SELECT * FROM buku WHERE id = " . $pesanan['buku_id'];
$result_buku = mysqli_query($conn, $query_buku);
$buku = mysqli_fetch_assoc($result_buku);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Status Pesanan</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Status Pesanan</h1>
        <div class="card">
            <div class="card-header">
                <h2><?php echo $buku['judul']; ?></h2>
            </div>
            <div class="card-body">
                <p>Nama Pembeli: <?php echo $pesanan['nama_pembeli']; ?></p>
                <p>Alamat Pembeli: <?php echo $pesanan['alamat_pembeli']; ?></p>
                <p>Email Pembeli: <?php echo $pesanan['email_pembeli']; ?></p>
                <p>Metode Pembayaran: <?php echo $pesanan['metode_pembayaran']; ?></p>
                <p>Status Pesanan: <?php echo $pesanan['status_pesanan']; ?></p>
            </div>
        </div>
    </div>
</body>
</html>