<?php
require_once __DIR__ . '/../config/config.php';

$response = [
    'success' => false,
    'message' => 'Terjadi kesalahan.',
    'cart_count' => isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produk = isset($_POST['id_produk']) ? (int)$_POST['id_produk'] : 0;
    $quantity_to_add = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

    if ($id_produk > 0 && $quantity_to_add > 0) {
        $stmt = $conn->prepare("SELECT stok FROM produk WHERE id_produk = ?");
        $stmt->bind_param("i", $id_produk);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if ($product) {
            $stok_tersedia = $product['stok'];
            $kuantitas_di_keranjang = isset($_SESSION['cart'][$id_produk]) ? $_SESSION['cart'][$id_produk] : 0;

            if (($kuantitas_di_keranjang + $quantity_to_add) > $stok_tersedia) {
                $response['message'] = 'Gagal! Kuantitas di keranjang akan melebihi stok yang tersedia (' . $stok_tersedia . ').';
            } else {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                if (isset($_SESSION['cart'][$id_produk])) {
                    $_SESSION['cart'][$id_produk] += $quantity_to_add;
                } else {
                    $_SESSION['cart'][$id_produk] = $quantity_to_add;
                }

                $response['success'] = true;
                $response['message'] = 'Produk berhasil ditambahkan!';
            }
        } else {
            $response['message'] = 'Produk tidak ditemukan.';
        }
    } else {
        $response['message'] = 'ID produk atau kuantitas tidak valid.';
    }
}

$response['cart_count'] = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>