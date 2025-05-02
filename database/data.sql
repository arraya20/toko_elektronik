-- Membuat database
CREATE DATABASE IF NOT EXISTS toko_elektronik;
USE toko_elektronik;

-- Tabel untuk menyimpan data produk
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    thumbnail VARCHAR(255) NOT NULL,
    nama_produk VARCHAR(255) NOT NULL,
    kategori_id INT NOT NULL,
    harga DECIMAL(15,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0
);

-- Tabel untuk menyimpan kategori produk
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL
);

-- Tabel untuk menyimpan penjualan
CREATE TABLE penjualan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    total_penjualan DECIMAL(15,2) NOT NULL,
    jumlah_item INT NOT NULL
);

-- Tabel untuk menyimpan detail penjualan per kategori (pie chart)
CREATE TABLE penjualan_kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori_id INT NOT NULL,
    bulan INT NOT NULL,
    tahun INT NOT NULL,
    total_penjualan DECIMAL(15,2) NOT NULL,
    jumlah_item INT NOT NULL
);

-- Data sampel untuk kategori
INSERT INTO kategori (nama) VALUES
                                ('Smartphone'),
                                ('Laptop');

-- Data sampel untuk produk
INSERT INTO produk  (thumbnail, nama_produk, kategori_id, harga, stok) VALUES
                                                                           ('https://images.unsplash.com/photo-1723637151988-f88618d58103?q=80&w=3474&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Huawei P60', 1, 15000000, 50),
                                                                           ('https://images.unsplash.com/photo-1726828497839-5a9c238326b2?q=80&w=3432&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'iPhone 16', 1, 12000000, 70),
                                                                           ('https://images.unsplash.com/photo-1724323254250-6a275c0467a1?q=80&w=3432&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Samsung Fold 6', 1, 23000000, 60),
                                                                           ('https://images.unsplash.com/photo-1724322535079-11b08f7f5c88?q=80&w=3432&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Google Pixel 9', 1, 8000000, 90),
                                                                           ('https://images.unsplash.com/photo-1659135890064-d57187f0946c?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Macbook Pro M2', 2, 24000000, 45),
                                                                           ('https://images.unsplash.com/photo-1713470812508-c276021f1b93?q=80&w=3474&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Huawei Matebook D15', 2, 10000000, 30);

-- Data sampel untuk penjualan
INSERT INTO penjualan (tanggal, total_penjualan, jumlah_item) VALUES
                                                                  ('2024-11-01', 27000000, 2),
                                                                  ('2025-12-1', 45000000, 3),
                                                                  ('2025-01-01', 30000000, 3),
                                                                  ('2025-02-01', 34000000, 2),
                                                                  ('2025-03-01', 16000000, 2),
                                                                  ('2025-04-01', 48000000, 3);

-- Data sampel untuk penjualan per kategori
INSERT INTO penjualan_kategori (kategori_id, bulan, tahun, total_penjualan, jumlah_item) VALUES
                                                                                             (1,4,2025, 24000000, 2),
                                                                                             (2, 4, 2025, 24000000, 1);

