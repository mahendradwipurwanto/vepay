<div class="alert alert-soft-primary">
	<small>Saat rate harga baru anda simpan, maka secara otomatis rate harga yang aktif akan
		mengikuti data tersebut</small>
</div>
<div class="row mb-3">
	<div class="col-5">
		<form action="<?= site_url('api/master/setPriceProduct');?>" method="post" class="js-validate need-validate m-0"
			novalidate enctype="multipart/form-data">
			<input type="hidden" name="m_product_id" value="<?= $m_product_id;?>">
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
			<div class="mb-4">
				<div class="js-form-message">
					<label for="inputFee" class="form-label">FEE</label>
					<div class="input-group input-group-sm">
						<input type="text" name="fee" id="inputFee" class="form-control form-control-sm" min="0"
							max="100" placeholder="Fee" onkeypress="return isNumberKey(event)" required>
						<span class="input-group-text" id="basic-addon1">%</span>
					</div>
					<span class="invalid-feedback">Harap masukkan rate harga yang valid.</span>
				</div>
				<small class="text-secondary">Gunakan . untuk koma. Misal 2.5%</small>
			</div>

			<div class="modal-footer p-0 pt-3">
				<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-soft-primary btn-sm">Simpan</button>
			</div>
		</form>
	</div>
	<div class="col-7">
		<h4 class="text-primary">Riwayat Rate Harga</h4>
		<ul class="list-group list-group-flush" style="max-height: 250px; overflow-y: auto;">
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
				<i class="ml-2">- Fee <?= $val->fee;?>%</i>
				<?php if($val->status != 1):?>
				<i role="button" class="bi bi-check-square text-secondary open-second-modal-active"
					style="margin-left: 5px" id="modal-active-<?= $val->id;?>"></i>
				<?php endif;?>
				<i role="button" class="bi bi-trash text-secondary open-second-modal-delete" style="margin-left: 5px"
					id="modal-delete-<?= $val->id;?>"></i>
			</li>

			<!-- Modal -->
			<div class="modal fade modal-backdrop-custom" id="modal-active-<?= $val->id;?>-second-modal" tabindex="-1"
				aria-labelledby="mdlDeleteLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-sm">
					<div class="modal-content shadow-sm">
						<form action="<?= site_url('api/master/activePriceProduct');?>" method="post"
							class="js-validate need-validate m-0" novalidate enctype="multipart/form-data">
							<input type="hidden" name="m_product_id" value="<?= $m_product_id;?>">
							<input type="hidden" name="type" value="<?= $val->type;?>">
							<input type="hidden" name="m_price_id" value="<?= $val->id;?>">
							<div class="modal-header">
								<h5 class="modal-title" id="mdlDeleteLabel">Aktifkan rate harga</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal"
									aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<p>Apakah anda ingin mengaktifkan rate harga <b>Rp.
										<?= number_format($val->price,0,",",".")?></b>?</p>
								<div class="modal-footer mx-0 px-0 mb-0 pb-0">
									<button type="button" class="btn btn-outline-secondary btn-sm"
										data-bs-dismiss="modal">Batal</button>
									<button type="submit" class="btn btn-soft-primary btn-sm">Aktifkan</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End Modal -->

			<!-- Modal -->
			<div class="modal fade modal-backdrop-custom" id="modal-delete-<?= $val->id;?>-second-modal" tabindex="-1"
				aria-labelledby="mdlDeleteLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-sm">
					<div class="modal-content shadow-sm">
						<form action="<?= site_url('api/master/deletePriceProduct');?>" method="post"
							class="js-validate need-validate m-0" novalidate enctype="multipart/form-data">
							<input type="hidden" name="m_product_id" value="<?= $m_product_id;?>">
							<input type="hidden" name="type" value="<?= $val->type;?>">
							<input type="hidden" name="m_price_id" value="<?= $val->id;?>">
							<input type="hidden" name="status" value="<?= $val->status;?>">
							<div class="modal-header">
								<h5 class="modal-title" id="mdlDeleteLabel">Hapus rate harga</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal"
									aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<p>Apakah anda ingin menghapus rate harga <b>Rp.
										<?= number_format($val->price,0,",",".")?></b>?</p>
								<div class="modal-footer mx-0 px-0 mb-0 pb-0">
									<button type="button" class="btn btn-outline-secondary btn-sm"
										data-bs-dismiss="modal">Batal</button>
									<button type="submit" class="btn btn-soft-primary btn-sm">Hapus</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- End Modal -->

			<?php endforeach;?>
			<?php else:?>
			<li class="list-group-item">
				<i class="bi-sliders list-group-icon"></i> Atur rate harga
			</li>
			<?php endif;?>
		</ul>
	</div>
</div>
<script>
	$(document).ready(function () {

		$('.open-second-modal-active').each(function () {
			$(this).on('click', function () {
				$('#' + $(this).attr('id') + '-second-modal').modal('show');
			});
		});

		$('.open-second-modal-delete').each(function () {
			$(this).on('click', function () {
				$('#' + $(this).attr('id') + '-second-modal').modal('show');
			});
		});
	});

</script>
