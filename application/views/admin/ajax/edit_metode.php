<form action="<?= site_url('api/master/saveMetode');?>" method="post"
    enctype="multipart/form-data" class="js-validate need-validate" novalidate>
    <input type="hidden" name="id" value="<?= $metode->id;?>" required>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Metode</label>
        <input class="form-control form-control-sm" type="text"
            name="metode" value="<?= $metode->metode;?>" required>
    </div>
    <div class="mb-3">
        <figure class="text-center">
            <img src="<?= base_url()?><?= $metode->image?>" id="metode-preview" class="img-thumbnail img-fluid" alt="<?= $metode->image?>"
                onerror="this.onerror=null;this.src='<?= base_url();?><?= 'assets/images/placeholder.jpg'?>';">
        </figure>
        <label for="metode-upload" class="form-label">Gambar <small
                class="text-muted">(optional)</small>:</label>
        <div class="input-group">
            <input type="file" class="form-control form-control-sm imgprev" name="image"
                accept="image/* .svg" id="metode-upload">
        </div>
        <small class="text-muted">Max file size 1Mb</small>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Atas nama/Email/Nama Akun</label>
        <input class="form-control form-control-sm" type="text" name="atas_nama"
            placeholder="Ketikkan atas nama" value="<?= $metode->atas_nama;?>" required>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">No Rekening/No Akun/No Telepon</label>
        <input class="form-control form-control-sm" type="text" name="no_rekening"
            placeholder="Ketikkan nomor rekening" value="<?= $metode->no_rekening;?>" required>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Keterangan <small
                class="text-secondary">(optional)</small></label>
        <textarea class="form-control form-control-sm" type="text"
            name="description"><?= $metode->description;?></textarea>
    </div>

    <div class="modal-footer px-0 pb-0">
        <button type="button" class="btn btn-white btn-sm"
            data-bs-dismiss="modal">batal</button>
        <button type="submit" class="btn btn-info btn-sm">Simpan</button>
    </div>
</form>