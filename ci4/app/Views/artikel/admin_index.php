<?= $this->include('template/admin_header'); ?>

<div style="text-align: left; padding: 20px;">
    <h2><?= $title; ?></h2>

    <div style="margin-bottom: 20px;">
        <form method="get" class="form-search" style="display: flex; gap: 10px;">
            <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data..." 
                   style="padding: 8px; width: 300px; border: 1px solid #ddd; border-radius: 4px;">
            
            <input type="submit" value="Cari" class="btn btn-primary" 
                   style="padding: 8px 20px; width: auto; cursor: pointer;">
        </form>
    </div>

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
                    <a class="btn" href="<?= base_url('/admin/artikel/edit/' . $row['id']);?>">Ubah</a>
                    <a class="btn btn-danger" onclick="return confirm('Yakin hapus?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']);?>">Hapus</a>
                </td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td colspan="4" style="text-align:center;">Belum ada data.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <?= $pager->only(['q'])->links(); ?>
    </div>
</div>

<?= $this->include('template/admin_footer'); ?>
