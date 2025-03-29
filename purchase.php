<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM buku WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$buku = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Buku</title>
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
        .btn-checkout {
            background-color: #007bff;
            color: white;
        }
        .btn-checkout:hover {
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
        <h1 class="mb-4 text-center">Pembelian Buku</h1>
        <div class="card">
            <img src="images/<?php echo $buku['image']; ?>" class="card-img-top thumbnail" alt="<?php echo $buku['judul']; ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo $buku['judul']; ?></h5>
                <p class="card-text"><?php echo $buku['sinopsis']; ?></p>
                <p class="price">Rp<?php echo number_format($buku['harga'], 0, ',', '.'); ?></p>
                <form action="checkout.php" method="post">
                    <input type="hidden" name="buku_id" value="<?php echo $buku['id']; ?>">
                    <div class="form-group">
                        <label for="jumlah">Jumlah:</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-checkout">Checkout</button>
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