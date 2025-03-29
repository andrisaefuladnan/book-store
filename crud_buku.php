<?php
include 'db.php';

// Fungsi untuk mendapatkan semua data buku
function getAllBuku() {
    global $conn;
    $query = "SELECT * FROM buku";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fungsi untuk mendapatkan data buku berdasarkan ID
function getBukuById($id) {
    global $conn;
    $query = "SELECT * FROM buku WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Fungsi untuk menambah data buku
function addBuku($judul, $sinopsis, $harga, $kategori_id) {
    global $conn;
    $query = "INSERT INTO buku (judul, sinopsis, harga, kategori_id) VALUES ('$judul', '$sinopsis', '$harga', $kategori_id)";
    return mysqli_query($conn, $query);
}

// Fungsi untuk mengedit data buku
function updateBuku($id, $judul, $sinopsis, $harga, $kategori_id) {
    global $conn;
    $query = "UPDATE buku SET judul = '$judul', sinopsis = '$sinopsis', harga = '$harga', kategori_id = $kategori_id WHERE id = $id";
    return mysqli_query($conn, $query);
}

// Fungsi untuk menghapus data buku
function deleteBuku($id) {
    global $conn;
    $query = "DELETE FROM buku WHERE id = $id";
    return mysqli_query($conn, $query);
}
?>