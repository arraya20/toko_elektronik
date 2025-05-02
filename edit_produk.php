<?php
include 'koneksi.php';

// Ambil data produk berdasarkan id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM produk WHERE id = $id";
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    $produk = mysqli_fetch_assoc($result);

    if (!$produk) {
        header("Location: admin.php");
        exit();
    }
} else {
    header("Location: admin.php");
    exit();
}

// Proses edit produk
if (isset($_POST['submit'])) {
    $thumbnail = $_POST['thumbnail'];
    $kategori_id = $_POST['kategori'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $query = "UPDATE produk SET 
              thumbnail = '$thumbnail', 
              kategori_id = '$kategori_id', 
              nama_produk = '$nama_produk', 
              harga = $harga,
              stok = '$stok'
              WHERE id = $id";

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
    <title>Edit Produk - Toko Elektronik</title>
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
        <h2>Edit Produk</h2>

        <div class="card">
            <div class="card-header">
                Form Edit Produk
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
                        <input type="text" class="form-control" id="thumbnail" name="thumbnail" value="<?php echo $produk['thumbnail']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $produk['kategori_id']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo $produk['nama_produk']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $produk['harga']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $produk['stok']; ?>" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    <a href="admin.php" class="btn btn-danger">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>