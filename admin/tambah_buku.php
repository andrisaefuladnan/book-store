<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Fungsi untuk mengubah ukuran gambar
function resizeImage($sourcePath, $destinationPath, $width, $height) {
    list($sourceWidth, $sourceHeight, $sourceType) = getimagesize($sourcePath);

    switch ($sourceType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }

    $destinationImage = imagecreatetruecolor($width, $height);
    imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);

    switch ($sourceType) {
        case IMAGETYPE_JPEG:
            imagejpeg($destinationImage, $destinationPath);
            break;
        case IMAGETYPE_PNG:
            imagepng($destinationImage, $destinationPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($destinationImage, $destinationPath);
            break;
    }

    imagedestroy($sourceImage);
    imagedestroy($destinationImage);

    return true;
}

// Proses tambah buku
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan semua data yang diperlukan ada dalam array $_POST
    if (isset($_POST['judul'], $_POST['sinopsis'], $_POST['harga'], $_POST['kategori_id'], $_FILES['image']['name'])) {
        $judul = $_POST['judul'];
        $sinopsis = $_POST['sinopsis'];
        $harga = $_POST['harga'];
        $kategori_id = $_POST['kategori_id'];
        $image = $_FILES['image']['name'];
        $target_dir = "../images/";

        // Periksa apakah direktori tujuan ada, jika tidak buat direktori tersebut
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Upload image
        $target_file = $target_dir . basename($image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Ubah ukuran gambar menjadi 113x170 piksel (4x6 cm pada 72 DPI)
            $resized_file = $target_dir . 'resized_' . basename($image);
            resizeImage($target_file, $resized_file, 113, 170);

            // Gunakan prepared statements untuk mencegah SQL Injection
            $stmt = $conn->prepare("INSERT INTO buku (judul, sinopsis, harga, kategori_id, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdss", $judul, $sinopsis, $harga, $kategori_id, $resized_file);
            if ($stmt->execute()) {
                header("Location: buku_berhasil_ditambahkan.php");
                exit;
            } else {
                $error = "Error: " . $stmt->error;
            }
        } else {
            $error = "Gagal mengunggah file.";
        }
    } else {
        $error = "Semua field harus diisi!";
    }
}

// Query untuk mendapatkan kategori
$query_kategori = "SELECT * FROM kategori";
$result_kategori = mysqli_query($conn, $query_kategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Tambah Buku Baru</title>
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
            <h1 class="mb-4">Tambah Buku Baru</h1>
            <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Judul:</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Sinopsis:</label>
                    <textarea name="sinopsis" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Harga:</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kategori:</label>
                    <select name="kategori_id" class="form-control" required>
                        <?php while ($row = mysqli_fetch_assoc($result_kategori)) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sampul:</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Buku</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>