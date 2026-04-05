<?= $this->include('template/admin_header'); ?>

<div class="form-container">
    <h2>Tambah Artikel</h2>
    <form action="" method="post">
        <div class="group-input">
            <label>Judul Artikel</label>
            <input type="text" name="judul" placeholder="Masukkan judul artikel" required>
        </div>
        <div class="group-input">
            <label>Isi Artikel</label>
            <textarea name="isi" rows="10" placeholder="Tuliskan isi artikel di sini"></textarea>
        </div>
        <div class="group-button">
            <input type="submit" value="Simpan" class="btn btn-submit">
            <a href="<?= base_url('/admin/artikel');?>" class="btn btn-cancel">Batal</a>
        </div>
    </form>
</div>

<?= $this->include('template/admin_footer'); ?>