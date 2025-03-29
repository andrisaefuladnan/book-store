<?php
include 'db.php';

// Query untuk mendapatkan kategori buku
$query = "SELECT * FROM kategori";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Kategori Buku</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Kategori Buku</h1>
        <ul class="list-group">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <li class="list-group-item"><?php echo $row['nama']; ?></li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>