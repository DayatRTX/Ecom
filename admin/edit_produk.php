<?php
require_once __DIR__ . '/../config/config.php';

$id_produk = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_produk === 0) {
    header('Location: index.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM produk WHERE id_produk = ?");
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    echo "Produk tidak ditemukan.";
    exit();
}

$kategori_sql = "SELECT * FROM kategori";
$kategori_result = $conn->query($kategori_sql);

$page_title = "Edit Produk";
include 'admin_header.php';

$notification = '';
if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
    $notification = '<div class="notif-sukses">Produk berhasil diperbarui!</div>';
}
?>

<div class="admin-page">
    <?php echo $notification; ?>
    <div class="form-container">
        <form action="../api/proses_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_produk" value="<?php echo $product['id_produk']; ?>">
            <input type="hidden" name="gambar_lama" value="<?php echo $product['gambar']; ?>">

            <div class="form-grid">
                <div class="form-panel">
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" id="nama_produk" name="nama_produk" value="<?php echo htmlspecialchars($product['nama_produk']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="merek">Merek</label>
                        <input type="text" id="merek" name="merek" value="<?php echo htmlspecialchars($product['merek']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_kategori">Kategori</label>
                        <select id="id_kategori" name="id_kategori" required>
                            <?php while($k = $kategori_result->fetch_assoc()): ?>
                                <option value="<?php echo $k['id_kategori']; ?>" <?php echo ($k['id_kategori'] == $product['id_kategori']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($k['nama_kategori']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" id="harga" name="harga" value="<?php echo $product['harga']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" id="stok" name="stok" value="<?php echo $product['stok']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" required><?php echo htmlspecialchars($product['deskripsi']); ?></textarea>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary">Update Produk</button>
                        <a href="index.php" class="btn btn-outline">Batal</a>
                    </div>
                </div>
                <aside class="preview-panel">
                    <h4>Gambar Saat Ini</h4>
                    <img src="../assets/<?php echo htmlspecialchars($product['gambar']); ?>" alt="" id="previewImage" class="image-preview">
                    <div class="form-group">
                        <label for="gambar">Ganti Gambar (opsional)</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*">
                        <div class="file-input-hint">Pilih file baru untuk mengganti gambar. Preview akan menggantikan gambar saat ini.</div>
                    </div>
                </aside>
            </div>
        </form>
        <script>
            (function(){
                const input = document.getElementById('gambar');
                const img = document.getElementById('previewImage');
                if (!input) return;
                input.addEventListener('change', function(e){
                    const file = e.target.files && e.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = function(ev){ img.src = ev.target.result; };
                    reader.readAsDataURL(file);
                });
            })();
        </script>
    </div>
</div>

</main>
</body>
</html>