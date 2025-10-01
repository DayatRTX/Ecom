<?php
require_once __DIR__ . '/../config/config.php';

if (isset($_GET['id'])) {
    $id_produk = (int)$_GET['id'];

    $stmt_select = $conn->prepare("SELECT gambar FROM produk WHERE id_produk = ?");
    $stmt_select->bind_param("i", $id_produk);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    if ($row = $result->fetch_assoc()) {
        $gambar_file = $row['gambar'];
        $file_path = '../assets/' . $gambar_file;
        if (file_exists($file_path)) {
            unlink($file_path); 
        }
    }
    $stmt_select->close();

    $stmt_delete = $conn->prepare("DELETE FROM produk WHERE id_produk = ?");
    $stmt_delete->bind_param("i", $id_produk);

    if ($stmt_delete->execute()) {
        header("Location: ../admin/index.php?status=sukses_hapus");
        exit();
    } else {
        echo "Error: " . $stmt_delete->error;
    }
    $stmt_delete->close();
}
$conn->close();
?>