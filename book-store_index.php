<?php
include 'db.php';

// Query untuk mendapatkan daftar buku
$query_buku = "SELECT buku.*, kategori.nama AS kategori_nama FROM buku LEFT JOIN kategori ON buku.kategori_id = kategori.id";
$result_buku = mysqli_query($conn, $query_buku);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Book Store</title>
    <style>
        .thumbnail {
            width: 150px;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Buku</h1>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result_buku)) { ?>
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="images/<?php echo $row['image']; ?>" class="card-img-top thumbnail" alt="<?php echo $row['judul']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                            <p class="card-text"><strong>Harga:</strong> Rp<?php echo $row['harga']; ?></p>
                            <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>