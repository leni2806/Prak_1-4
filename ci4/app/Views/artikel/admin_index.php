<?= $this->include('template/admin_header'); ?>

<table class="table">
    <thead>
        <tr>
            <th width="50">ID</th>
            <th>Judul</th>
            <th width="100">Status</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if($artikel): foreach($artikel as $row): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td>
                <b><?= $row['judul']; ?></b>
                <p><small><?= substr($row['isi'], 0, 50); ?>...</small></p>
            </td>
            <td><?= $row['status'] ?? '0'; ?></td>
            <td>
                <a class="btn btn-primary" href="<?= base_url('/admin/artikel/edit/' . $row['id']);?>">Ubah</a>
                <a class="btn btn-danger" onclick="return confirm('Yakin hapus?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']);?>">Hapus</a>
            </td>
        </tr>
    <?php endforeach; else: ?>
        <tr>
            <td colspan="4">Belum ada data.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?= $this->include('template/admin_footer'); ?>