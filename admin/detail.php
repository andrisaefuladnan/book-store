<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$query = "SELECT buku.*, kategori.nama AS kategori_nama FROM buku LEFT JOIN kategori ON buku.kategori_id = kategori.id WHERE buku.id = ?";
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
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Detail Buku</title>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        .container {
            flex: 1;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px;
            text-align: left;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background-color: #007bff;
            color: white;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .thumbnail {
            width: 150px;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="dashboard.php">Dashboard Admin</a>
        <a href="daftar_buku.php">Daftar Buku</a>
        <a href="tambah_buku.php">Tambah Buku Baru</a>
        <a href="pesanan.php">Pesanan</a>
        <a href="akun.php">Akun/User</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <div class="container mt-5">
            <h1 class="mb-4">Detail Buku</h1>
            <div class="card">
                <img src="../images/<?php echo $buku['image']; ?>" class="card-img-top thumbnail" alt="<?php echo $buku['judul']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $buku['judul']; ?></h5>
                    <p class="card-text"><?php echo $buku['sinopsis']; ?></p>
                    <p class="card-text"><strong>Harga:</strong> Rp<?php echo $buku['harga']; ?></p>
                    <p class="card-text"><strong>Kategori:</strong> <?php echo $buku['kategori_nama']; ?></p>
                    <a href="dashboard.php" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>