<?php
// Mengimpor file koneksi database
include 'config.php';

// --- LOGIKA PENGAMBILAN DATA ---

// 1. Ambil semua kategori untuk tombol filter
$sql_kategori = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$result_kategori = $conn->query($sql_kategori);

// 2. Cek parameter dari URL untuk filtering & searching
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$kategori_id = isset($_GET['kategori']) ? (int)$_GET['kategori'] : 0;

// 3. Bangun query produk secara dinamis
$sql_produk = "SELECT id_produk, nama_produk, harga, gambar FROM produk WHERE 1=1";
$params = [];
$types = '';

// Tambahkan kondisi pencarian jika ada
if (!empty($search_term)) {
    $sql_produk .= " AND nama_produk LIKE ?";
    $params[] = "%" . $search_term . "%";
    $types .= 's';
}

// Tambahkan kondisi filter kategori jika ada
if ($kategori_id > 0) {
    $sql_produk .= " AND id_kategori = ?";
    $params[] = $kategori_id;
    $types .= 'i';
}

// 4. Eksekusi query produk dengan prepared statement
$stmt = $conn->prepare($sql_produk);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result_produk = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Gitar Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'header.php'; // Memanggil file header terpisah ?>

    <main>
        <h2 class="section-title">
            <?php 
            // Judul dinamis berdasarkan pencarian
            echo !empty($search_term) ? 'Hasil Pencarian untuk "' . htmlspecialchars($search_term) . '"' : 'Produk Terlaris';
            ?>
        </h2>

        <div class="category-filters">
            <a href="index.php" class="<?php echo ($kategori_id == 0) ? 'active' : ''; ?>">Semua</a>
            <?php
            if ($result_kategori->num_rows > 0) {
                while($kategori = $result_kategori->fetch_assoc()) {
                    $active_class = ($kategori_id == $kategori['id_kategori']) ? 'active' : '';
                    echo '<a href="index.php?kategori=' . $kategori['id_kategori'] . '" class="' . $active_class . '">' . htmlspecialchars($kategori['nama_kategori']) . '</a>';
                }
            }
            ?>
        </div>

        <div class="product-grid">
            <?php
            if ($result_produk->num_rows > 0) {
                // Loop untuk menampilkan setiap produk
                while($row = $result_produk->fetch_assoc()) {
            ?>
                    <div class="product-card">
                        <a href="detail_produk.php?id=<?php echo $row['id_produk']; ?>">
                            <img src="assets/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>">
                        </a>
                        <h3><?php echo htmlspecialchars($row['nama_produk']); ?></h3>
                        <p class="price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                    </div>
            <?php
                }
            } else {
                echo "<p>Produk tidak ditemukan.</p>";
            }
            // Menutup statement dan koneksi
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Rodaluka Acoustic. All Rights Reserved.</p>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>