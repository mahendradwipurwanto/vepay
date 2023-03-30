<form action="<?= site_url('api/master/editProduct');?>" method="post" class="js-validate need-validate m-0" novalidate enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $product->id;?>">
	<input type="hidden" name="old_image" value="<?= $product->image;?>">
	<div class="mb-3">
		<div class="js-form-message">
			<label for="inputName" class="form-label">Nama produk</label>
			<input type="text" name="name" id="inputName" class="form-control form-control-sm"
				value="<?= $product->name;?>" required>
			<span class="invalid-feedback">Harap masukkan nama produk yang valid.</span>
		</div>
	</div>
	<div class="mb-3">
		<figure>
			<img src="#" id="imgthumbnailedit" class="img-thumbnail img-fluid" alt="<?= $product->image?>"
				onerror="this.onerror=null;this.src='<?= $product->image?>';">
		</figure>
		<label for="poster-product" class="form-label">Gambar <small class="text-muted">(optional)</small>:</label>
		<div class="input-group">
			<input type="file" class="form-control form-control-sm imgprevedit" name="image" accept="image/* .svg" id="poster-product">
		</div>
		<small class="text-muted">Max file size 1Mb</small>
	</div>
	<div class="mb-3">
		<div class="js-form-message">
			<label for="inputKategori" class="form-label">Kategori <small
					class="text-secondary">(optional)</small></label>
			<div class="tom-select-custom">
				<select class="js-select form-select form-select-sm" name="categories" autocomplete="off"
					data-hs-tom-select-options='{"placeholder": "Pilih kategori"}'>
					<?php if(!empty($kategori)):?>
					<?php foreach($kategori as $key => $val):?>
					<option value="<?= $val->id;?>"
						<?php if($val->id == $product->m_categories_id):?>selected<?php endif;?>><?= $val->categories;?>
					</option>
					<?php endforeach;?>
					<?php else:?>
					<option>Harap tambahkan master kategori</option>
					<?php endif;?>
				</select>
			</div>
			<span class="invalid-feedback">Harap masukkan nomor kategori yang valid.</span>
		</div>
	</div>
	<div class="mb-3">
		<div class="js-form-message">
			<label for="inputDescription" class="form-label">Deskripsi <small
					class="text-secondary">(optional)</small></label>
			<textarea type="text" id="inputDescription" name="description" class="form-control form-control-sm"
				placeholder="Deskripsi" rows="3"><?= $product->description;?></textarea>
			<span class="invalid-feedback">Harap masukkan deskripsi yang valid.</span>
		</div>
	</div>

	<div class="modal-footer p-0 pt-3">
		<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-soft-primary btn-sm">Simpan</button>
	</div>
</form>


<!-- JS Implementing Plugins -->
<script>
	//binds to onchange event of your input field
	$('input.imgprev').each(function () {
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
