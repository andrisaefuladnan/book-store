<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $buku_id = $_POST['buku_id'];
    $jumlah = $_POST['jumlah'];

    $query = "SELECT * FROM buku WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $buku_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $buku = $result->fetch_assoc();

    $total_harga = $buku['harga'] * $jumlah;
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
    <title>Checkout</title>
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
        .btn-confirm {
            background-color: #007bff;
            color: white;
        }
        .btn-confirm:hover {
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
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Checkout</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Pembelian</h5>
                <p class="card-text"><strong>Judul Buku:</strong> <?php echo $buku['judul']; ?></p>
                <p class="card-text"><strong>Jumlah:</strong> <?php echo $jumlah; ?></p>
                <p class="card-text"><strong>Total Harga:</strong> Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></p>
                <form action="order_details.php" method="post">
                    <input type="hidden" name="buku_id" value="<?php echo $buku_id; ?>">
                    <input type="hidden" name="jumlah" value="<?php echo $jumlah; ?>">
                    <input type="hidden" name="total_harga" value="<?php echo $total_harga; ?>">
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat:</label>
                        <textarea name="alamat" id="alamat" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No HP:</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-confirm">Konfirmasi Pembelian</button>
                </form>
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