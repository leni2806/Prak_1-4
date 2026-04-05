<?= $this->include('template/admin_header'); ?>

<div class="form-container">
    <h2><?= $title; ?></h2>
    <form action="" method="post">
        <div class="group-input">
            <label>Judul Artikel</label>
            <input type="text" name="judul" value="<?= $data['judul']; ?>" required>
        </div>
        <div class="group-input">
            <label>Isi Artikel</label>
            <textarea name="isi" rows="10"><?= $data['isi']; ?></textarea>
        </div>
        <div class="group-button">
            <input type="submit" value="Simpan Perubahan" class="btn btn-submit">
            <a href="<?= base_url('/admin/artikel');?>" class="btn btn-cancel">Batal</a>
        </div>
    </form>
</div>

<?= $this->include('template/admin_footer'); ?>