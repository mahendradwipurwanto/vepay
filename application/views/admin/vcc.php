<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">VCC Member
				<button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
					data-bs-target="#tambah"><i class="bi bi-tag"></i> Tambah data</button>
			</h1>
			<p class="docs-page-header-text">Kelola VCC pada website anda</p>
		</div>
	</div>
</div>
<!-- End Page Header -->


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-borderless table-thead-bordered nowrap w-100 align-middle dataTables"
					id="table">
					<thead>
						<tr>
							<th width="10%">No.</th>
							<th width="25%"></th>
							<th>Nama VCC</th>
							<th>Member</th>
							<th>VCC</th>
							<th>Jenis</th>
							<th>Saldo</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($vcc)):?>
						<?php $no = 1; foreach($vcc as $val):?>
						<tr>
							<td><?= $no++;?></td>
							<td>
								<button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal"
									data-bs-target="#edit-<?= $val->id;?>"><i class="bi-pencil-square"></i></button>
								<button type="button" class="btn btn-soft-danger btn-sm" data-bs-toggle="modal"
									data-bs-target="#delete-<?= $val->id;?>"><i class="bi-trash"></i></button>
							</td>
							<td><?= is_null($val->vcc_name) || $val->vcc_name == "" ? '-' : $val->vcc_name;?></td>
							<td><?= $val->name;?></td>
							<td><?= $val->jenis_vcc;?></td>
							<td><?= $val->number;?></td>
							<td>Rp. <?= number_format($val->saldo,0,",",".")?></td>
						</tr>

						<div id="delete-<?= $val->id; ?>" class="modal fade" tabindex="-1" role="dialog"
							aria-labelledby="delete" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="detailUserTitle">Hapus data</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<form action="<?= site_url('api/master/deleteVcc');?>" method="post"
											class="js-validate need-validate" novalidate>
											<input type="hidden" name="id" value="<?= $val->id;?>">
											<p>Apakah kamu yakin ingin menghapus vcc <?= $val->number;?> ini?</p>
											<div class="modal-footer px-0 pb-0">
												<button type="button" class="btn btn-white btn-sm"
													data-bs-dismiss="modal">Tidak</button>
												<button type="submit" class="btn btn-danger btn-sm">Ya</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<!-- Modal -->
						<div id="edit-<?= $val->id;?>" class="modal fade" tabindex="-1" role="dialog"
							aria-labelledby="add" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="detailUserTitle">Ubah data</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Close"></button>
									</div>
									<div class="modal-body" id="edit-content">
										<form action="<?= site_url('api/master/saveVcc');?>" method="post"
											enctype="multipart/form-data" class="js-validate need-validate" novalidate>
											<input type="hidden" name="id" value="<?= $val->id;?>" required>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Nama VCC</label>
												<input class="form-control form-control-sm" type="text" name="vcc_name"
													placeholder="Ketikkan Nama VCC" value="<?= $val->vcc_name;?>"
													required>
											</div>

											<div class="mb-3">
												<div class="js-form-message">
													<label for="inputKategori" class="form-label">Jenis VCC</label>
													<div class="tom-select-custom">
														<select class="js-select form-select form-select-sm" name="jenis_vcc"
															autocomplete="off" data-hs-tom-select-options='{"placeholder": "Pilih jenis VCC", "hideSearch": true}'>
																<option value="Master Card" <?php if($val->jenis_vcc == 'Master Card'):;?>selected<?php endif;?>>Master Card</option>
																<option value="VISA" <?php if($val->jenis_vcc == 'VISA'):;?>selected<?php endif;?>>VISA</option>
														</select>
													</div>
													<span class="invalid-feedback">Harap masukkan nomor kategori yang valid.</span>
												</div>
											</div>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Nomor VCC</label>
												<input class="form-control form-control-sm" type="text" name="number"
													placeholder="Ketikkan Nomor VCC" value="<?= $val->number;?>"
													required>
											</div>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Atas Nama</label>
												<input class="form-control form-control-sm" type="text" name="holder"
													placeholder="Ketikkan data" value="<?= $val->holder;?>" required>
											</div>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Valid Date</label>
												<input class="js-input-mask form-control form-control-sm" type="text"
													name="valid_date" placeholder="MM/YY"
													value="<?= $val->valid_date;?>"
													data-hs-mask-options='{"mask": "00/00"}' required>
											</div>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Kode Security</label>
												<input class="js-input-mask form-control form-control-sm" type="text"
													name="security_code" placeholder="XXX"
													value="<?= $val->security_code;?>"
													data-hs-mask-options='{"mask": "000"}' required>
											</div>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Saldo</label>
												<div class="input-group input-group-sm mb-3">
													<span class="input-group-text" id="basic-saldo">Rp. </span>
													<input type="text" class="form-control form-control-sm"
														placeholder="saldo" name="saldo" aria-label="saldo"
														value="<?= $val->saldo;?>" aria-describedby="basic-saldo"
														required>
												</div>
											</div>

											<div class="modal-footer px-0 pb-0">
												<button type="button" class="btn btn-white btn-sm"
													data-bs-dismiss="modal">batal</button>
												<button type="submit" class="btn btn-info btn-sm">Simpan</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach;?>
						<?php endif;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div id="tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="detailUserTitle">Tambah Data</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('api/master/saveVcc');?>" method="post" enctype="multipart/form-data"
					class="js-validate need-validate" novalidate>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Nama VCC</label>
						<input class="form-control form-control-sm" type="text" name="vcc_name"
							placeholder="Ketikkan Nama VCC" required>
					</div>

					<div class="mb-3">
						<div class="js-form-message">
							<label for="inputMember" class="form-label">Member</label>
							<div class="tom-select-custom">
								<select class="js-select form-select form-select-sm" autocomplete="off" id="inputMember"
									name="member"
									data-hs-tom-select-options='{"placeholder": "Member...", "hideSearch": true}'>
									<?php if(!empty($member)):?>
									<?php foreach ($member as $key => $val):?>
									<option value="<?= $val->user_id;?>"><?= $val->name;?></option>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
							<span class="invalid-feedback">Harap masukkan member yang valid.</span>
						</div>
					</div>

					<div class="mb-3">
						<div class="js-form-message">
							<label for="inputKategori" class="form-label">Jenis VCC</label>
							<div class="tom-select-custom">
								<select class="js-select form-select form-select-sm" name="jenis_vcc"
									autocomplete="off" data-hs-tom-select-options='{"placeholder": "Pilih jenis VCC"}'>
									<option value="Master Card">Master Card</option>
									<option value="VISA">VISA</option>
								</select>
							</div>
							<span class="invalid-feedback">Harap masukkan nomor kategori yang valid.</span>
						</div>
					</div>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Nomor VCC</label>
						<input class="form-control form-control-sm" type="text" name="number"
							placeholder="Ketikkan Nomor VCC" required>
					</div>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Atas Nama</label>
						<input class="form-control form-control-sm" type="text" name="holder"
							placeholder="Ketikkan data" required>
					</div>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Valid Date</label>
						<input class="js-input-mask form-control form-control-sm" type="text" name="valid_date"
							placeholder="MM/YY" data-hs-mask-options='{"mask": "00/00"}' required>
					</div>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Kode Security</label>
						<input class="js-input-mask form-control form-control-sm" type="text" name="security_code"
							placeholder="XXX" data-hs-mask-options='{"mask": "000"}' required>
					</div>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Saldo</label>
						<div class="input-group input-group-sm mb-3">
							<span class="input-group-text" id="basic-saldo">Rp. </span>
							<input type="text" class="form-control form-control-sm" placeholder="saldo" name="saldo"
								aria-label="saldo" aria-describedby="basic-saldo" required>
						</div>
					</div>

					<div class="modal-footer px-0 pb-0">
						<button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">batal</button>
						<button type="submit" class="btn btn-primary btn-sm">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- <script>
	
	const showMdlVccEdit = id => {
		$("#edit-content").html(
			`<center class="py-5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang memuat ...</center>`
		);

		$('#edit').modal('show')

		jQuery.ajax({
			url: "<?= site_url('ajax/master/getDetailVcc') ?>",
			type: 'POST',
			data: {
				VCC_id: id
			},
			success: function (data) {
				$("#edit-content").html(data);
			}
		});
	}
</script> -->
