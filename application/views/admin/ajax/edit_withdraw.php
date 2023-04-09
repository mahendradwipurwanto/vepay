<form action="<?= site_url('api/master/saveWithdraw');?>" method="post" enctype="multipart/form-data"
	class="js-validate need-validate" novalidate>
	<input type="hidden" name="id" value="<?= $withdraw->id;?>" required>

	<div class="mb-3">
		<label for="inputSubject" class="form-label">Withdraw</label>
		<input class="form-control form-control-sm" type="text" name="withdraw" value="<?= $withdraw->withdraw;?>" required>
	</div>
	<div class="mb-3">
		<figure class="text-center">
			<img src="<?= base_url()?><?= $withdraw->image?>" id="withdraw-preview" class="img-thumbnail img-fluid"
				alt="<?= $withdraw->image?>"
				onerror="this.onerror=null;this.src='<?= base_url();?><?= 'assets/images/placeholder.jpg'?>';">
		</figure>
		<label for="withdraw-upload" class="form-label">Gambar <small class="text-muted">(optional)</small>:</label>
		<div class="input-group">
			<input type="file" class="form-control form-control-sm imgprev" name="image" accept="image/*, .svg"
				id="withdraw-upload">
		</div>
		<small class="text-muted">Max file size 1Mb</small>
	</div>

	<div class="mb-3">
		<label for="inputSubject" class="form-label">Atas nama/Email/Nama Akun</label>
		<input class="form-control form-control-sm" type="text" name="atas_nama" placeholder="Ketikkan atas nama"
			value="<?= $withdraw->atas_nama;?>" required>
	</div>

	<div class="mb-3">
		<label for="inputSubject" class="form-label">No Rekening/No Akun/No Telepon</label>
		<input class="form-control form-control-sm" type="text" name="no_rekening" placeholder="Ketikkan nomor rekening"
			value="<?= $withdraw->no_rekening;?>" required>
	</div>

	<div class="mb-3">
		<label for="inputSubject" class="form-label">Keterangan <small class="text-secondary">(optional)</small></label>
		<textarea class="form-control form-control-sm" type="text"
			name="description"><?= $withdraw->description;?></textarea>
	</div>

	<div class="modal-footer px-0 pb-0">
		<button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">batal</button>
		<button type="submit" class="btn btn-info btn-sm">Simpan</button>
	</div>
</form>

<!-- JS Implementing Plugins -->
<script>
	//binds to onchange event of your input field
	$('input.imgprev').each(function () {
		console.log('#' + $(this).attr('id'));
		$('#' + $(this).attr('id')).bind('change', function () {
			var parent_id = $(this).attr('id').split('-')
			//this.files[0].size gets the size of your file.
			if (this.files[0].size > (1 * 1024 * 1024)) {
				Swal.fire({
					text: 'File size to large, maximum file size is 1 Mb !',
					icon: 'warning',
				})
				this.value = "";
			} else {
				const [file] = this.files
				if (file) {
					$('#' + parent_id[0] + '-preview').attr('src', URL.createObjectURL(file));
				}
			}
		})
	});
</script>
