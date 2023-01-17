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
        <input class="js-input-mask form-control form-control-sm" type="text" name="valid_date"
            placeholder="MM/YY" value="<?= $vcc->valid_date;?>" data-hs-mask-options='{"mask": "00/00"}' required>
    </div>

    <div class="mb-3">
        <label for="inputSubject" class="form-label">Kode Security</label>
        <input class="js-input-mask form-control form-control-sm" type="text" name="security_code"
            placeholder="XXX" value="<?= $vcc->security_code;?>" data-hs-mask-options='{"mask": "000"}' required>
    </div>

    <div class="modal-footer px-0 pb-0">
        <button type="button" class="btn btn-white btn-sm"
            data-bs-dismiss="modal">batal</button>
        <button type="submit" class="btn btn-info btn-sm">Simpan</button>
    </div>
</form>