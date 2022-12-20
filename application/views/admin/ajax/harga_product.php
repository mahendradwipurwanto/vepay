<form action="<?= site_url('api/master/setPriceProduct');?>" method="post" class="js-validate need-validate m-0"
	novalidate enctype="multipart/form-data">
	<input type="hidden" name="m_product_id" value="<?= $m_product_id;?>">
	<div class="alert alert-soft-primary">
		<small>Saat rate harga baru anda simpan, maka secara otomatis rate harga yang aktif akan
			mengikuti data tersebut</small>
	</div>
	<div class="row mb-3">
		<div class="col-5">
			<div class="mb-3">
				<div class="js-form-message">
					<label for="inputHarga" class="form-label">Tipe Rate Harga</label>
					<div class="row">
						<div class="col-sm mb-2 mb-sm-0">
							<!-- Form Radio -->
							<label class="form-control" for="formOptionTopUp">
								<span class="form-check">
									<input type="radio" class="form-check-input" name="type" value="Top Up"
										id="formOptionTopUp" checked>
									<span class="form-check-label">Top Up</span>
								</span>
							</label>
							<!-- End Form Radio -->
						</div>

						<div class="col-sm mb-2 mb-sm-0">
							<!-- Form Radio -->
							<label class="form-control" for="formOptionWithdraw">
								<span class="form-check">
									<input type="radio" class="form-check-input" name="type" value="Withdraw"
										id="formOptionWithdraw">
									<span class="form-check-label">Withdraw</span>
								</span>
							</label>
							<!-- End Form Radio -->
						</div>
					</div>
					<span class="invalid-feedback">Harap tipe rate harga yang valid.</span>
				</div>
			</div>
			<div class="mb-4">
				<div class="js-form-message">
					<label for="inputHarga" class="form-label">Harga</label>
					<div class="input-group input-group-sm">
						<span class="input-group-text" id="basic-addon1">Rp.</span>
						<input type="text" name="price" id="inputHarga" class="form-control form-control-sm"
							placeholder="Harga" onkeypress="return isNumberKey(event)" required>
						<span class="input-group-text" id="basic-addon1">per satuan</span>
					</div>
					<span class="invalid-feedback">Harap masukkan rate harga yang valid.</span>
				</div>
			</div>

			<div class="modal-footer p-0 pt-3">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-soft-primary btn-sm">Simpan</button>
			</div>
		</div>
		<div class="col-7">
			<h4 class="text-primary">Riwayat Rate Harga</h4>
			<ul class="list-group list-group-flush" style="max-height: 235px; overflow-y: auto;">
				<?php if(!empty($price_history)):?>
				<?php foreach ($price_history as $key => $val):?>
				<li class="list-group-item">
					<i class="bi-<?= $val->type == "Top Up" ? 'wallet2' : 'cash-stack';?> list-group-icon"></i> Rp.
					<?= number_format($val->price,0,",",".")?>
					<span
						class="badge bg-soft-<?= $val->type == "Top Up" ? 'success' : 'primary';?> ml-3"><?= $val->type == "Top Up" ? 'Top Up' : 'Withdraw';?></span>
					<?php if($val->status == 1):?>
					<span class="badge bg-soft-warning">aktif</span>
					<?php endif;?>
				</li>
				<?php endforeach;?>
				<?php else:?>
				<li class="list-group-item">
					<i class="bi-sliders list-group-icon"></i> Atur rate harga
				</li>
				<?php endif;?>
			</ul>
		</div>
	</div>
</form>
