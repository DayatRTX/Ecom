<?php
require_once __DIR__ . '/../config/config.php';

$page_title = "Panel Produk";
include 'admin_header.php';

$notification = '';
if (isset($_GET['status']) && $_GET['status'] == 'sukses_hapus') {
    $notification = '<div class="notif-sukses">Produk baru saja dihapus!</div>';
}

$sql = "SELECT p.*, k.nama_kategori FROM produk p JOIN kategori k ON p.id_kategori = k.id_kategori ORDER BY p.id_produk DESC";
$result = $conn->query($sql);
?>

<div class="admin-page">
    <?php echo $notification; ?>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 class="section-title" style="margin-bottom: 0;">Daftar Produk</h1>
        <a href="tambah_produk.php" class="btn btn-primary">Tambah Produk Baru</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Merek</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="../assets/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>"></td>
                        <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
                        <td><?php echo htmlspecialchars($row['merek']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['stok']; ?></td>
                        <td class="action-links">
                            <a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>" class="edit">Edit</a>
                            <a href="hapus_produk.php?id=<?php echo $row['id_produk']; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Belum ada produk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</main>
</body>
</html>

<?php
$conn->close();
?>