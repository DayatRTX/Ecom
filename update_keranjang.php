<?php
include 'config.php'; // config.php sudah menjalankan session_start()

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produk = isset($_POST['id_produk']) ? (int)$_POST['id_produk'] : 0;
    $new_quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

    if ($id_produk > 0 && isset($_SESSION['cart'][$id_produk])) {
        // Ambil stok produk
        $stmt = $conn->prepare("SELECT harga, stok FROM produk WHERE id_produk = ?");
        $stmt->bind_param("i", $id_produk);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($product) {
            // Validasi kuantitas tidak melebihi stok
            if ($new_quantity > $product['stok']) {
                $new_quantity = $product['stok']; // Batasi kuantitas sesuai stok
                $response['message'] = 'Stok tidak mencukupi. Kuantitas disesuaikan.';
            }

            if ($new_quantity <= 0) {
                unset($_SESSION['cart'][$id_produk]); // Hapus item jika kuantitas 0 atau kurang
            } else {
                $_SESSION['cart'][$id_produk] = $new_quantity; // Update kuantitas
            }

            // Siapkan data untuk dikirim kembali sebagai JSON
            $response['success'] = true;
            $response['new_quantity'] = $new_quantity;
            $response['new_subtotal_formatted'] = "Rp " . number_format($product['harga'] * $new_quantity, 0, ',', '.');
        }
    }
}

// Hitung ulang total keseluruhan dan jumlah item
$grand_total = 0;
if (!empty($_SESSION['cart'])) {
    $product_ids_str = implode(',', array_keys($_SESSION['cart']));
    $products_result = $conn->query("SELECT id_produk, harga FROM produk WHERE id_produk IN ($product_ids_str)");
    $products_data = array_column($products_result->fetch_all(MYSQLI_ASSOC), 'harga', 'id_produk');
    
    foreach ($_SESSION['cart'] as $id => $qty) {
        $grand_total += $products_data[$id] * $qty;
    }
}

$response['new_grand_total_formatted'] = "Rp " . number_format($grand_total, 0, ',', '.');
$response['cart_count'] = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>