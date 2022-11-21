<form action="<?= site_url('api/master/editProduct');?>" method="post" class="js-validate need-validate m-0" novalidate>
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
			<img src="#" id="imgthumbnail" class="img-thumbnail img-fluid" alt="<?= $product->image?>"
				onerror="this.onerror=null;this.src='<?= $product->image?>';">
		</figure>
		<label for="poster-product" class="form-label">Gambar <small class="text-muted">(optional)</small>:</label>
		<div class="input-group">
			<input type="file" class="form-control imgprev" name="image" accept="image/*" id="poster-product">
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
					<?php if(!empty($categories)):?>
					<?php foreach($categories as $key => $val):?>
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
			<label for="inputHarga" class="form-label">Harga</label>
			<div class="input-group input-group-sm">
				<span class="input-group-text" id="basic-addon1">Rp.</span>
				<input type="text" name="price" id="inputHarga" class="form-control form-control-sm"
					value="<?= $product->price;?>" onkeypress="return isNumberKey(event)" required>
				<span class="input-group-text" id="basic-addon1">per satuan</span>
			</div>
			<span class="invalid-feedback">Harap masukkan harga yang valid.</span>
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
