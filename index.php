<?php
include 'koneksi.php';

// Menghitung jumlah produk
$query = "SELECT COUNT(*) as total FROM produk";
$result = mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
$data = mysqli_fetch_assoc($result);
$total_produk = $data['total'];

// Menghitung total harga semua produk
$query = "SELECT SUM(harga) as total_harga FROM produk";
$result = mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
$data = mysqli_fetch_assoc($result);
$total_harga = $data['total_harga'];

// Membuat data dummy untuk 6 bulan terakhir jika tabel belum ada
$labels_line = [];
$data_line = [];

// Cek jika tabel penjualan sudah ada
$table_check = mysqli_query($koneksi, "SHOW TABLES LIKE 'penjualan'");
if(mysqli_num_rows($table_check) > 0) {
    $sql_line = "SELECT DATE_FORMAT(tanggal, '%b %Y') as bulan, total_penjualan FROM penjualan ORDER BY tanggal ASC LIMIT 6";
    $result_line = mysqli_query($koneksi, $sql_line);

    if ($result_line && mysqli_num_rows($result_line) > 0) {
        while($row = mysqli_fetch_assoc($result_line)) {
            $labels_line[] = $row["bulan"];
            $data_line[] = $row["total_penjualan"];
        }
    }
} else {
    // Data dummy jika tabel belum ada
    $months = [
        date('M Y', strtotime('-5 months')),
        date('M Y', strtotime('-4 months')),
        date('M Y', strtotime('-3 months')),
        date('M Y', strtotime('-2 months')),
        date('M Y', strtotime('-1 months')),
        date('M Y')
    ];

    $sales = [45000000, 67500000, 52000000, 75000000, 60000000, 80000000];

    $labels_line = $months;
    $data_line = $sales;
}

// Query untuk pie chart (distribusi penjualan per kategori)
$labels_pie = [];
$data_pie = [];
$colors_pie = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];

// Cek jika tabel penjualan_kategori sudah ada
$table_check = mysqli_query($koneksi, "SHOW TABLES LIKE 'penjualan_kategori'");
if(mysqli_num_rows($table_check) > 0) {
    $sql_pie = "SELECT k.nama as kategori, pk.total_penjualan 
                FROM penjualan_kategori pk 
                JOIN kategori k ON pk.kategori_id = k.id 
                WHERE pk.bulan = MONTH(CURRENT_DATE()) AND pk.tahun = YEAR(CURRENT_DATE())";
    $result_pie = mysqli_query($koneksi, $sql_pie);

    if ($result_pie && mysqli_num_rows($result_pie) > 0) {
        while($row = mysqli_fetch_assoc($result_pie)) {
            $labels_pie[] = $row["kategori"];
            $data_pie[] = $row["total_penjualan"];
        }
    }
} else {
    // Data dummy
    $categories = ['Smartphone', 'Laptop', 'Aksesoris', 'Smart Home'];
    $sales_per_category = [45000000, 20000000, 5000000, 10000000];

    $labels_pie = $categories;
    $data_pie = $sales_per_category;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Toko Elektronik</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Tambahkan Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <h2>Dashboard</h2>

        <div class="card">
            <div class="card-header">
                Ringkasan
            </div>
            <div class="card-body">
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1; background-color: #0984e3; color: white; padding: 20px; border-radius: 5px;">
                        <h4>Total Produk</h4>
                        <h2><?php echo $total_produk; ?></h2>
                    </div>
                    <div style="flex: 1; background-color: #0984e3; color: white; padding: 20px; border-radius: 5px;">
                        <h4>Total Nilai Produk</h4>
                        <h2>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Charts Section -->
        <div class="card">
            <div class="card-header">
                Analisis Penjualan
            </div>
            <div class="card-body">
                <div class="charts-row">
                    <!-- Line Chart - Trend Penjualan -->
                    <div class="chart-card">
                        <h4>Tren Penjualan (6 Bulan Terakhir)</h4>
                        <div class="chart-container">
                            <canvas id="salesLineChart"></canvas>
                        </div>
                    </div>

                    <!-- Pie Chart - Penjualan Per Kategori -->
                    <div class="chart-card">
                        <h4>Distribusi Penjualan per Kategori</h4>
                        <div class="chart-container">
                            <canvas id="categoryPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Line Chart
    const salesLineChart = new Chart(
        document.getElementById('salesLineChart'),
        {
            type: 'line',
            data: {
                labels: <?= json_encode($labels_line) ?>,
                datasets: [{
                    label: 'Total Penjualan',
                    data: <?= json_encode($data_line) ?>,
                    backgroundColor: 'rgba(9, 132, 227, 0.2)',
                    borderColor: '#0984e3',
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + context.parsed.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        }
    );

    // Pie Chart
    const categoryPieChart = new Chart(
        document.getElementById('categoryPieChart'),
        {
            type: 'pie',
            data: {
                labels: <?= json_encode($labels_pie) ?>,
                datasets: [{
                    data: <?= json_encode($data_pie) ?>,
                    backgroundColor: <?= json_encode($colors_pie) ?>,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.raw !== null) {
                                    label += 'Rp ' + context.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                                return label;
                            }
                        }
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        }
    );
</script>
</body>
</html>