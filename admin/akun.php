<?php
include '../db.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Tambah pengguna baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        $success = "Pengguna berhasil ditambahkan!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}

// Ubah sandi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    
    $stmt = $conn->prepare("SELECT * FROM admin WHERE id = ? AND password = ?");
    $stmt->bind_param("is", $_SESSION['admin'], $current_password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_password, $_SESSION['admin']);
        if ($stmt->execute()) {
            $success = "Sandi berhasil diubah!";
        } else {
            $error = "Error: " . $stmt->error;
        }
    } else {
        $error = "Sandi saat ini salah!";
    }
}

// Query untuk mendapatkan daftar admin
$query_akun = "SELECT * FROM admin";
$result_akun = mysqli_query($conn, $query_akun);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Akun/User</title>
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
            <h1 class="mb-4">Akun/User</h1>
            <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
            <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
            <div class="row">
                <div class="col-md-6">
                    <h2>Daftar Pengguna</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result_akun)) { ?>
                                <tr>
                                    <td><?php echo $row['username']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h2>Tambah Pengguna Baru</h2>
                    <form method="post">
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="add_user" class="btn btn-primary">Tambah Pengguna</button>
                    </form>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <h2>Ubah Sandi</h2>
                    <form method="post">
                        <div class="form-group">
                            <label>Sandi Saat Ini:</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Sandi Baru:</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <button type="submit" name="change_password" class="btn btn-primary">Ubah Sandi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>