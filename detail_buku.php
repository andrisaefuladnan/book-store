<?php
include 'db.php';

// Mendapatkan ID buku dari URL
$buku_id = $_GET['id'];

// Query untuk mendapatkan detail buku
$query = "SELECT * FROM buku WHERE id = $buku_id";
$result = mysqli_query($conn, $query);
$buku = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Detail Buku</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center"><?php echo $buku['judul']; ?></h1>
        <div class="row">
            <div class="col-md-4">
                <img src="images/<?php echo $buku['image']; ?>" class="img-fluid" alt="<?php echo $buku['judul']; ?>">
            </div>
            <div class="col-md-8">
                <p><?php echo $buku['sinopsis']; ?></p>
                <p>Harga: <?php echo $buku['harga']; ?></p>
                <a href="checkout.php?id=<?php echo $buku['id']; ?>" class="btn btn-primary">Beli</a>
            </div>
        </div>
    </div>
</body>
</html>