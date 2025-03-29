<?php
include 'db.php';

// Fungsi untuk mendapatkan semua data pemesanan
function getAllPemesanan() {
    global $conn;
    $query = "SELECT * FROM pemesanan";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mendapatkan data pemesanan berdasarkan ID
function getPemesananById($id) {
    global $conn;
    $query = "SELECT * FROM pemesanan WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Fungsi untuk menambah data pemesanan
function addPemesanan($nama_pembeli, $alamat_pembeli, $email_pembeli, $buku_id, $metode_pembayaran) {
    global $conn;
    $query = "INSERT INTO pemesanan (nama_pembeli, alamat_pembeli, email_pembeli, buku_id, metode_pembayaran) VALUES ('$nama_pembeli', '$alamat_pembeli', '$email_pembeli', $buku_id, '$metode_pembayaran')";
    return mysqli_query($conn, $query);
}

// Fungsi untuk mengedit data pemesanan
function updatePemesanan($id, $status_pesanan) {
    global $conn;
    $query = "UPDATE pemesanan SET status_pesanan = '$status_pesanan' WHERE id = $id";
    return mysqli_query($conn, $query);
}

// Fungsi untuk menghapus data pemesanan
function deletePemesanan($id) {
    global $conn;
    $query = "DELETE FROM pemesanan WHERE id = $id";
    return mysqli_query($conn, $query);
}
?>