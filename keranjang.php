<?php
include 'config/config.php';
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$products = [];
$total_harga = 0;

if (!empty($cart_items)) {
    $product_ids = array_keys($cart_items);
    
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    $sql = "SELECT * FROM produk WHERE id_produk IN ($placeholders)";
    
    $stmt = $conn->prepare($sql);
    $types = str_repeat('i', count($product_ids));
    $stmt->bind_param($types, ...$product_ids);
    
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[$row['id_produk']] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko GitarKu</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="assets/logo.png" type="image/png">
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="cart-page">
        <h1 class="section-title">Keranjang Belanja Anda</h1>
        
        <?php if (empty($cart_items) || empty($products)): ?>
            <p class="cart-empty">Keranjang Anda masih kosong.</p>
        <?php else: ?>
            <div class="cart-container">
                <div class="cart-header">
                    <div class="header-product">Produk</div>
                    <div class="header-price">Harga Satuan</div>
                    <div class="header-quantity">Kuantitas</div>
                    <div class="header-total">Total Harga</div>
                    <div class="header-action">Aksi</div>
                </div>

                <?php foreach ($cart_items as $id => $quantity): ?>
                    <?php 
                        if (!isset($products[$id])) continue;
                        $product = $products[$id]; 
                        $subtotal = $product['harga'] * $quantity;
                        $total_harga += $subtotal;
                    ?>
                    <div class="cart-item" id="item-row-<?php echo $id; ?>">
                        <div class="item-product">
                            <a href="detail_produk.php?id=<?php echo $product['id_produk']; ?>">
                                <img src="assets/<?php echo htmlspecialchars($product['gambar']); ?>" alt="<?php echo htmlspecialchars($product['nama_produk']); ?>">
                            </a>
                            <a href="detail_produk.php?id=<?php echo $product['id_produk']; ?>">
                                <span><?php echo htmlspecialchars($product['nama_produk']); ?></span>
                            </a>
                        </div>
                        <div class="item-price">Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></div>
                        <div class="item-quantity">
                             <div class="quantity-control">
                                <button class="qty-btn" data-id="<?php echo $id; ?>" data-action="decrease">-</button>
                                <input type="number" class="qty-input" value="<?php echo $quantity; ?>" 
                                       min="0" max="<?php echo $product['stok']; ?>" 
                                       data-id="<?php echo $id; ?>" data-price="<?php echo $product['harga']; ?>">
                                <button class="qty-btn" data-id="<?php echo $id; ?>" data-action="increase">+</button>
                            </div>
                        </div>
                        <div class="item-total" id="subtotal-<?php echo $id; ?>">
                            Rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
                        </div>
                        <div class="item-action">
                            <a href="/ecom/api/hapus_item.php?id=<?php echo $id; ?>">Hapus</a>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="cart-summary">
                    <div class="summary-total">
                        <span>Total Keseluruhan:</span>
                        <span class="total-price" id="grand-total">
                            Rp <?php echo number_format($total_harga, 0, ',', '.'); ?>
                        </span>
                    </div>
                    <a href="checkout.php" class="btn btn-primary btn-checkout">Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </main>
    
    <footer>
        <p>&copy; 2025 Rodaluka Acoustic. All Rights Reserved.</p>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>