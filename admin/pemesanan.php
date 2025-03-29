<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Proses ubah status pesanan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status_pesanan = $_POST['status_pesanan'];

    // Gunakan prepared statements untuk mencegah SQL Injection
    $stmt = $conn->prepare("UPDATE pemesanan SET status_pesanan = ? WHERE id = ?");
    $stmt->bind_param("si", $status_pesanan, $id);
    $stmt->execute();
}

// Query untuk mendapatkan data pemesanan
$query_pemesanan = "SELECT * FROM pemesanan";
$result_pemesanan = $conn->query($query_pemesanan);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Data Pemesanan</title>
</head>
<body>
    <h1>Kelola Data Pemesanan</h1>

    <table>
        <tr>
            <th>Nama Pembeli</th>
            <th>Alamat Pembeli</th>
            <th>Email Pembeli</th>
            <th>Buku</th>
            <th>Metode Pembayaran</th>
            <th>Status Pesanan</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result_pemesanan->fetch_assoc()) {
            $query_buku = "SELECT * FROM buku WHERE id = " . $row['buku_id'];
            $result_buku = $conn->query($query_buku);
            $buku = $result_buku->fetch_assoc();
        ?>
            <tr>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <td><?php echo $row['nama_pembeli']; ?></td>
                    <td><?php echo $row['alamat_pembeli']; ?></td>
                    <td><?php echo $row['email_pembeli']; ?></td>
                    <td><?php echo $buku['judul']; ?></td>
                    <td><?php echo $row['metode_pembayaran']; ?></td>
                    <td>
                        <select name="status_pesanan" required>
                            <option value="pending" <?php if ($row['status_pesanan'] == 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="diproses" <?php if ($row['status_pesanan'] == 'diproses') echo 'selected'; ?>>Diproses</option>
                            <option value="selesai" <?php if ($row['status_pesanan'] == 'selesai') echo 'selected'; ?>>Selesai</option>
                        </select>
                    </td>
                    <td>
                        <button type="submit">Ubah Status</button>
                    </td>
                </form>
            </tr>
        <?php } ?>
    </table>
</body>
</html>