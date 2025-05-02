<?php
include 'koneksi.php';

// Proses hapus produk jika ada parameter id_hapus
if (isset($_GET['id_hapus'])) {
    $id = $_GET['id_hapus'];
    $query = "DELETE FROM produk WHERE id = $id";
    mysqli_query($koneksi, $query);
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Toko Elektronik</title>
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
        <h2>Kelola Produk</h2>

        <div class="card">
            <div class="card-header">
                <span>Daftar Produk</span>
                <a href="tambah_produk.php" class="btn btn-primary">Tambah Produk</a>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Thumbnail</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM produk ORDER BY id DESC";
                    $result = mysqli_query($koneksi, $query);
                    $no = 1;

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td><img src='" . $row['thumbnail'] . "' width='50'></td>";
                        echo "<td>" . $row['nama_produk'] . "</td>";
                        echo "<td>" . $row['kategori_id'] . "</td>";
                        echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                        echo "<td>" . $row['stok'] . "</td>";
                        echo "<td>
                                    <a href='edit_produk.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a>
                                    <a href='admin.php?id_hapus=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Apakah yakin ingin menghapus?\")'>Hapus</a>
                                </td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>