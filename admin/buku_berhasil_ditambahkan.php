<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Buku Berhasil Ditambahkan</title>
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
            <h1 class="mb-4">Buku Berhasil Ditambahkan!</h1>
            <p>Buku telah berhasil ditambahkan ke dalam sistem. Anda dapat melihat daftar buku atau menambahkan buku baru lagi.</p>
            <a href="daftar_buku.php" class="btn btn-primary">Lihat Daftar Buku</a>
            <a href="tambah_buku.php" class="btn btn-secondary">Tambah Buku Baru</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>