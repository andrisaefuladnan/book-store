<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'add' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM buku WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $buku = mysqli_fetch_assoc($result);

        if ($buku) {
            $item = [
                'id' => $buku['id'],
                'judul' => $buku['judul'],
                'harga' => $buku['harga'],
                'jumlah' => 1
            ];

            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['jumlah'] += 1;
            } else {
                $_SESSION['cart'][$id] = $item;
            }
        }
    } elseif ($action == 'remove' && isset($_GET['id'])) {
        $id = $_GET['id'];
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    } elseif ($action == 'update' && isset($_GET['id']) && isset($_GET['jumlah'])) {
        $id = $_GET['id'];
        $jumlah = $_GET['jumlah'];
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['jumlah'] = $jumlah;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-remove {
            background-color: #dc3545;
            color: white;
        }
        .btn-remove:hover {
            background-color: #c82333;
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
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
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
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4 text-center">Keranjang Belanja</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $item) {
                        $total += $item['harga'] * $item['jumlah'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['judul']); ?></td>
                            <td>Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                            <td>
                                <form action="cart.php" method="get">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="jumlah" value="<?php echo $item['jumlah']; ?>" min="1">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </td>
                            <td>Rp<?php echo number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="cart.php?action=remove&id=<?php echo $item['id']; ?>" class="btn btn-remove">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                        <td colspan="2">Rp<?php echo number_format($total, 0, ',', '.'); ?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" class="text-center">Keranjang belanja Anda kosong.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-right">
            <a href="checkout.php" class="btn btn-success">Checkout</a>
        </div>
    </div>

    <footer class="text-center mt-5 py-4 bg-light">
        <p>&copy; 2025 Book Store. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcndom/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>