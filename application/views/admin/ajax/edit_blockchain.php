<form action="<?= site_url('api/master/saveBlockchain');?>" method="post"
    enctype="multipart/form-data" class="js-validate need-validate" novalidate>
    <input type="hidden" name="id" value="<?= $blockchain->id;?>" required>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Blockchain</label>
        <input class="form-control form-control-sm" type="text"
            name="blockchain" value="<?= $blockchain->blockchain;?>" required>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Fee</label>
        <div class="input-group input-group-sm">
            <input type="text" name="fee" id="inputFee" class="form-control form-control-sm" min="0" max="100"
                placeholder="Fee" value="<?= $blockchain->fee;?>" onkeypress="return isNumberKey(event)" required>
            <span class="input-group-text" id="basic-addon1">%</span>
        </div>
        <span class="invalid-feedback">Harap masukkan rate harga yang valid.</span>
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