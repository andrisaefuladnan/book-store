<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Proses tambah, edit, hapus buku
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah'])) {
        $judul = $_POST['judul'];
        $sinopsis = $_POST['sinopsis'];
        $harga = $_POST['harga'];
        $kategori_id = $_POST['kategori_id'];
        $image = $_FILES['