<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // Simpan detail pesanan ke database
    foreach ($_SESSION['cart'] as $item) {
        $query = "INSERT INTO pesanan (buku_id, jumlah, total_harga, nama, alamat, no_hp) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $total_harga = $item['harga'] * $item['jumlah'];
        $stmt->bind_param("iiisss", $item['id'], $item['jumlah'], $total_harga, $nama, $alamat, $no_hp);
        $stmt->execute();
    }

    // Kosongkan keranjang setelah checkout
    unset($_SESSION['cart']);

    // Redirect ke halaman detail pesanan
    header("Location: order_details.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcndom/bootstrap/4.5.2/css/bootstrap.min.css">
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
           