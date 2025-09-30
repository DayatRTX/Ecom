<?php
require_once __DIR__ . '/../config/config.php';

$kategori_sql = "SELECT * FROM kategori";
$kategori_result = $conn->query($kategori_sql);

$page_title = "Tambah Produk";
include 'admin_header.php';

$notification = '';
if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
    $notification = '<div class="notif-sukses">Produk baru berhasil ditambahkan!</div>';
}

?>

<div class="admin-page">
     <?php echo $notification; ?>
    <div class="form-container">
        <form action="../api/proses_tambah.php" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-panel">
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" id="nama_produk" name="nama_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="merek">Merek</label>
                        <input type="text" id="merek" name="merek" required>
                    </div>
                    <div class="form-group">
                        <label for="id_kategori">Kategori</label>
                        <select id="id_kategori" name="id_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php while($k = $kategori_result->fetch_assoc()): ?>
                                <option value="<?php echo $k['id_kategori']; ?>"><?php echo htmlspecialchars($k['nama_kategori']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" id="harga" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" id="stok" name="stok" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" required></textarea>
                    </div>
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary">Simpan Produk</button>
                        <a href="index.php" class="btn btn-outline">Batal</a>
                    </div>
                </div>
                <aside class="preview-panel">
                    <h4>Preview Gambar</h4>
                    <img src="../assets/placeholder.png" alt="Preview" id="previewImage" class="image-preview">
                    <div class="form-group">
                        <label for="gambar">Gambar Produk</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*" required>
                        <div class="file-input-hint">Pilih file gambar (maks 2MB). Preview akan muncul di atas.</div>
                    </div>
                </aside>
            </div>
        </form>
    </div>
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

</main>
</body>
</html>