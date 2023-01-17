<form action="<?= site_url('api/master/saveVcc');?>" method="post"
    enctype="multipart/form-data" class="js-validate need-validate" novalidate>
    <input type="hidden" name="id" value="<?= $vcc->id;?>" required>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Nomor VCC</label>
        <input class="form-control form-control-sm" type="text" name="number"
            placeholder="Ketikkan Nomor VCC" value="<?= $vcc->number;?>" required>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Atas Nama</label>
        <input class="form-control form-control-sm" type="text" name="holder"
            placeholder="Ketikkan data" value="<?= $vcc->holder;?>" required>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Valid Date</label>
        <input class="form-control form-control-sm" type="text" name="valid_date"
            placeholder="Ketikkan data" value="<?= $vcc->valid_date;?>" required>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Kode Security</label>
        <input class="form-control form-control-sm" type="number" name="security_code"
            placeholder="Ketikkan data" value="<?= $vcc->security_code;?>" required>
    </div>

    <div class="modal-footer px-0 pb-0">
        <button type="button" class="btn btn-white btn-sm"
            data-bs-dismiss="modal">batal</button>
        <button type="submit" class="btn btn-info btn-sm">Simpan</button>
    </div>
</form>