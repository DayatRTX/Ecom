<?php
include 'config.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id === 0) {
    header('Location: index.php');
    exit();
}

$sql = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    $product = null;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product ? htmlspecialchars($product['nama_produk']) : 'Produk Tidak Ditemukan'; ?> - Rodaluka Acoustic</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main class="product-detail-page">
        <?php if ($product): ?>
            <div class="product-detail-container">
                <div class="product-image-container">
                    <img src="assets/<?php echo htmlspecialchars($product['gambar']); ?>" alt="<?php echo htmlspecialchars($product['nama_produk']); ?>">
                </div>
                <div class="product-info-container">
                    <h1 class="product-title"><?php echo htmlspecialchars($product['nama_produk']); ?></h1>
                    <p class="product-price">Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                    
                    <div class="product-description">
                        <h3>Deskripsi Produk</h3>
                        <p><?php echo nl2br(htmlspecialchars($product['deskripsi'])); ?></p>
                    </div>

                    <div class="product-stock">
                        <p>Stok Tersedia: <strong><?php echo $product['stok']; ?></strong></p>
                    </div>

                    <div class="quantity-selector">
                        <label for="quantity">Kuantitas</label>
                        <input type="number" id="quantity-input" name="quantity" value="1" min="1" max="<?php echo $product['stok']; ?>">
                    </div>

                    <div class="action-buttons">
                        <button type="button" id="add-to-cart-btn" data-product-id="<?php echo $product['id_produk']; ?>" class="btn btn-outline">Masukkan Keranjang</button>
                        <a href="checkout.php?id=<?php echo $product['id_produk']; ?>" class="btn btn-primary">Beli Sekarang</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p class="not-found">Maaf, produk yang Anda cari tidak ditemukan.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Rodaluka Acoustic. All Rights Reserved.</p>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>