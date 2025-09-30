<?php
include 'config.php';
if (isset($_GET['id'])) {
    $id_produk = (int)$_GET['id'];
    unset($_SESSION['cart'][$id_produk]);
}

header('Location: keranjang.php');
exit();
?>