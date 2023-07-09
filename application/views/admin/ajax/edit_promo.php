<form action="<?= site_url('api/master/editPromo');?>" method="post" enctype="multipart/form-data"
	class="js-validate need-validate" novalidate enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $promo->id;?>" required>
	<div class="row">
		<div class="col-6">
			<div class="mb-3">
				<label for="inputJenisPromo" class="form-label">Jenis</label>
				<div class="tom-select-custom">
					<select class="js-select form-select form-select-sm" autocomplete="off" name="jenis"
						id="inputJenisPromo"
						data-hs-tom-select-options='{"placeholder": "Pilih jenis promo", "hideSearch": true}' required>
						<option value="1" <?= $promo->jenis == 1 ? 'selected' : '';?>>Flat
						</option>
						<option value="2" <?= $promo->jenis == 2 ? 'selected' : '';?>>
							Presentage
						</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="mb-3">
				<label for="inputStatusPromo" class="form-label">Status</label>
				<div class="tom-select-custom">
					<select class="js-select form-select form-select-sm" autocomplete="off" name="status"
						id="inputStatusPromo" data-hs-tom-select-options='{"hideSearch": true}' required>
						<option value="1">Aktif</option>
						<option value="0">Tidak Aktif</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-7">
			<div class="mb-3">
				<label for="inputSubject" class="form-label">Nama Promo</label>
				<input class="form-control form-control-sm" type="text" name="nama" value="<?= $promo->nama;?>" required>
			</div>
		</div>
		<div class="col-5">
			<div class="mb-3">
				<label for="inputSubject" class="form-label">Pengguna</label>
				<select class="js-select form-select form-select-sm" autocomplete="off" name="jenis_pengguna"
					id="inputJenisPenggunaPromo" data-hs-tom-select-options='{"hideSearch": true}' required>
					<option value="0" <?php if($promo->jenis_pengguna == 0):?>selected<?php endif;?>>
						Semua Pengguna</option>
					<option value="1" <?php if($promo->jenis_pengguna == 1):?>selected<?php endif;?>>
						Pengguna Baru</option>
					<option value="2" <?php if($promo->jenis_pengguna == 2):?>selected<?php endif;?>>
						Private</option>
				</select>
			</div>
		</div>
	</div>
	<div class="mb-3">
		<figure class="text-center">
			<img src="<?= base_url()?><?= $promo->image?>" id="promo-preview" class="img-thumbnail img-fluid"
				alt="<?= $promo->image?>"
				onerror="this.onerror=null;this.src='<?= base_url();?><?= 'assets/images/placeholder.jpg'?>';">
		</figure>
		<label for="promo-upload" class="form-label">Gambar <small class="text-muted">(optional)</small>:</label>
		<div class="input-group">
			<input type="file" class="form-control form-control-sm imgprev" name="image" accept="image/*, .svg"
				id="promo-upload">
		</div>
		<small class="text-muted">Max file size 1Mb</small>
	</div>
	<div class="row">
		<div class="col-6">
			<div class="mb-3">
				<label for="inputKodePromo" class="form-label">Kode</label>
				<input class="form-control form-control-sm" id="inputKodePromo" onkeypress="return event.charCode >= 48"
					type="text" name="kode" value="<?= $promo->kode;?>" required>
			</div>
		</div>
		<div class="col-6">
			<div class="mb-3">
				<label for="inputNominalPromo" class="form-label">Nominal/Nilai</label>
				<div class="input-group input-group-sm flex-nowrap">
					<span class="input-group-text" id="addon-wrapping"><span
							id="symbol_promo"><?= $promo->jenis == 1 ? 'Rp.' : '%';?></span></span>
					<input type="number" class="form-control form-controls-sm" id="value_promo" name="value"
						onkeypress="return isNumberKey(event)" value="<?= $promo->value;?>" required>
				</div>
				<small class="text-secondary">Gunakan . untuk koma. Misal 2.5%</small>
			</div>
		</div>
		<div class="col-12" <?php if($promo->jenis == 1):?>style="display:none" <?php endif;?> id="maksimal-nominal">
			<div class="mb-3">
				<label for="inputNominalPromo" class="form-label">Maksimal
					nominal promo</label>
				<div class="input-group input-group-sm flex-nowrap">
					<span class="input-group-text" id="addon-wrapping"><span id="symbol_promo">Rp</span></span>
					<input type="number" class="form-control form-controls-sm" name="maksimal_promo"
						onkeypress="return event.charCode >= 48" value="<?= $promo->maksimal_promo;?>"
						placeholder="Nominal/Nilai Promo" required>
				</div>
				<small class="text-secondary">Maksimal nominal promo digunakan
					untuk memberi
					batasan
					pemotongan berapa persen dari promo yang digunakan</small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<div class="mb-3">
				<label for="inputSubject" class="form-label">Berlaku
					Sampai</label>
				<input class="form-control form-control-sm" type="date" name="expired"
					value="<?= date('Y-m-d', $promo->expired);?>" required>
			</div>
		</div>
		<div class="col-6">
			<div class="mb-3">
				<label for="inputSubject" class="form-label">Batas
					penggunaan</label>
				<input class="form-control form-control-sm" type="number" min="0" max="9999"
					onkeypress="return event.charCode >= 48" name="quota" value="<?= $promo->quota;?>"
					placeholder="∞ Unlimited">
				<small class="text-secondary">Kosongi untuk set ke tanpa bayas /
					unlimited.</small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="mb-3">
				<label for="inputKeterangan" class="form-label">Keterangan</label>
				<textarea name="desc" id="inputKeterangan" class="form-control form-control-sm" rows="3"
					placeholder="Keterangan promo"><?= $promo->desc;?></textarea>
			</div>
		</div>
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
			console.log($(this).attr('id'));
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
