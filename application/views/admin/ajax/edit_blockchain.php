<form action="<?= site_url('api/master/saveBlockchain');?>" method="post"
    enctype="multipart/form-data" class="js-validate need-validate" novalidate>
    <input type="hidden" name="id" value="<?= $blockchain->id;?>" required>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Blockchain</label>
        <input class="form-control form-control-sm" type="text"
            name="blockchain" value="<?= $blockchain->blockchain;?>" required>
    </div>
    <div class="mb-3">
        <figure class="text-center">
            <img src="<?= base_url()?><?= $blockchain->image?>" id="blockchain-preview" class="img-thumbnail img-fluid" alt="<?= $blockchain->image?>"
                onerror="this.onerror=null;this.src='<?= base_url();?><?= 'assets/images/placeholder.jpg'?>';">
        </figure>
        <label for="blockchain-upload" class="form-label">Gambar <small
                class="text-muted">(optional)</small>:</label>
        <div class="input-group">
            <input type="file" class="form-control form-control-sm imgprev" name="image"
                accept="image/* .svg" id="blockchain-upload">
        </div>
        <small class="text-muted">Max file size 1Mb</small>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Harga</label>
        <input class="form-control form-control-sm" type="text" name="price"
            placeholder="Ketikkan harga" value="<?= $blockchain->price;?>" required>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Fee</label>
        <input class="form-control form-control-sm" type="text" name="fee"
            placeholder="Ketikkan fee" value="<?= $blockchain->fee;?>" required>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Keterangan <small
                class="text-secondary">(optional)</small></label>
        <textarea class="form-control form-control-sm" type="text"
            name="description"><?= $blockchain->description;?></textarea>
    </div>

    <div class="modal-footer px-0 pb-0">
        <button type="button" class="btn btn-white btn-sm"
            data-bs-dismiss="modal">batal</button>
        <button type="submit" class="btn btn-info btn-sm">Simpan</button>
    </div>
</form>