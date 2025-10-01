<?php
require_once __DIR__ . '/../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $merek = $_POST['merek'];
    $id_kategori = $_POST['id_kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $gambar_name = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $target_dir = "../assets/";
    $target_file = $target_dir . basename($gambar_name);

    if (move_uploaded_file($gambar_tmp, $target_file)) {
        $stmt = $conn->prepare("INSERT INTO produk (nama_produk, merek, gambar, harga, stok, deskripsi, id_kategori) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdisi", $nama_produk, $merek, $gambar_name, $harga, $stok, $deskripsi, $id_kategori);

        if ($stmt->execute()) {
            header("Location: ../admin/tambah_produk.php?status=sukses");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Maaf, terjadi kesalahan saat mengupload file.";
    }
}
$conn->close();
?>