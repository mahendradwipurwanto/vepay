<form action="<?= site_url('api/master/saveMetode');?>" method="post"
    enctype="multipart/form-data" class="js-validate need-validate" novalidate>
    <input type="hidden" name="id" value="<?= $metode->id;?>" required>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Metode</label>
        <input class="form-control form-control-sm" type="text"
            name="metode" value="<?= $metode->metode;?>" required>
    </div>
    <div class="mb-3">
        <figure>
            <img src="#" id="imgthumbnailedit" class="img-thumbnail img-fluid" alt="<?= $metode->image?>"
                onerror="this.onerror=null;this.src='<?= base_url()?><?= $metode->image?>';">
        </figure>
        <label for="poster-product" class="form-label">Gambar <small
                class="text-muted">(optional)</small>:</label>
        <div class="input-group">
            <input type="file" class="form-control form-control-sm imgprevedit" name="image"
                accept="image/*" id="poster-product">
        </div>
        <small class="text-muted">Max file size 1Mb</small>
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