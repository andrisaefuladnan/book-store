-- Membuat database
CREATE DATABASE IF NOT EXISTS toko_buku_db;

-- Menggunakan database toko_buku_db
USE toko_buku_db;

-- Membuat tabel kategori buku
CREATE TABLE IF NOT EXISTS kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL
);

-- Membuat tabel buku
CREATE TABLE IF NOT EXISTS buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    sinopsis TEXT NOT NULL,
    harga DECIMAL(10, 2) NOT NULL,
    kategori_id INT,
    image VARCHAR(255),
    FOREIGN KEY (kategori_id) REFERENCES kategori(id)
);

-- Membuat tabel pemesanan
CREATE TABLE IF NOT EXISTS pemesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pembeli VARCHAR(255) NOT NULL,
    alamat_pembeli TEXT NOT NULL,
    email_pembeli VARCHAR(255) NOT NULL,
    buku_id INT,
    metode_pembayaran VARCHAR(255) NOT NULL,
    status_pesanan ENUM('pending', 'diproses', 'selesai') DEFAULT 'pending',
    FOREIGN KEY (buku_id) REFERENCES buku(id)
);

-- Membuat tabel admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(32) NOT NULL
);

-- Tambahkan pengguna admin dengan kata sandi yang telah di-hash menggunakan MD5
INSERT INTO admin (username, password) VALUES ('admin', MD5('123'));

-- Tambahkan contoh 5 buku ke dalam tabel buku
INSERT INTO buku (judul, sinopsis, harga, kategori_id, image) VALUES
('Buku Satu', 'Sinopsis Buku Satu', 50000, 1, 'buku1.jpg'),
('Buku Dua', 'Sinopsis Buku Dua', 60000, 1, 'buku2.jpg'),
('Buku Tiga', 'Sinopsis Buku Tiga', 70000, 2, 'buku3.jpg'),
('Buku Empat', 'Sinopsis Buku Empat', 80000, 2, 'buku4.jpg'),
('Buku Lima', 'Sinopsis Buku Lima', 90000, 3, 'buku5.jpg');