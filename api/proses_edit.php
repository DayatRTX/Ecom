<?php
require_once __DIR__ . '/../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $merek = $_POST['merek'];
    $id_kategori = $_POST['id_kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    $gambar_lama = $_POST['gambar_lama'];
    
    $gambar_name = $gambar_lama; 

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0 && !empty($_FILES['gambar']['name'])) {
        $new_gambar_name = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $target_dir = "../assets/";
        $target_file = $target_dir . basename($new_gambar_name);

        if (move_uploaded_file($gambar_tmp, $target_file)) {
            $gambar_name = $new_gambar_name; 
            if ($gambar_lama != $gambar_name && file_exists($target_dir . $gambar_lama)) {
                unlink($target_dir . $gambar_lama);
            }
        }
    }

    $stmt = $conn->prepare("UPDATE produk SET nama_produk=?, merek=?, gambar=?, harga=?, stok=?, deskripsi=?, id_kategori=? WHERE id_produk=?");
    $stmt->bind_param("sssdisii", $nama_produk, $merek, $gambar_name, $harga, $stok, $deskripsi, $id_kategori, $id_produk);

    if ($stmt->execute()) {
        header("Location: ../admin/edit_produk.php?id=" . $id_produk . "&status=sukses");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>