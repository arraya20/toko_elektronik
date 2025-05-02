<?php
include 'koneksi.php';

// Proses tambah produk
if (isset($_POST['submit'])) {
    $thumbnail = $_POST['thumbnail'];
    $kategori_id = $_POST['kategori'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $query = "INSERT INTO produk (thumbnail, kategori_id, nama_produk, harga, stok) VALUES ('$thumbnail', '$kategori_id', '$nama_produk', $harga,  $stok)";

    if (mysqli_query($koneksi, $query)) {
        header("Location: admin.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Toko Elektronik</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Toko Elektronik</h3>
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="admin.php">Produk</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Tambah Produk</h2>

        <div class="card">
            <div class="card-header">
                Form Tambah Produk
            </div>
            <div class="card-body">
                <?php if (isset($error)) : ?>
                    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="thumbnail">Link Thumbnail</label>
                        <input type="text" class="form-control" id="thumbnail" name="thumbnail" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori_id">Kategori</label>
                        <input type="text" class="form-control" id="kategori_id" name="kategori" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <a href="admin.php" class="btn btn-danger">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>