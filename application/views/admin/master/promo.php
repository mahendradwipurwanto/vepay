<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Master promo
				<button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
					data-bs-target="#tambah"><i class="bi bi-tag"></i> Tambah data</button>
			</h1>
			<p class="docs-page-header-text">Kelola master promo pada website anda</p>
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
							<th width="5%">No.</th>
							<th width="15%"></th>
							<th>Kode</th>
							<th>Promo</th>
							<th>Nilai/Nominal</th>
							<th>Maksimal promo</th>
							<th>Jenis</th>
							<th>Tersisa</th>
							<th>Status</th>
							<th>Expired</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($promo)):?>
						<?php $no = 1; foreach($promo as $val):?>
						<tr>
							<td><?= $no++;?></td>
							<td>
								<button type="button" class="btn btn-soft-info btn-sm"
									onclick="showMdlPromoEdit(<?= $val->id;?>)"><i
										class="bi-pencil-square"></i></button>
								<button type="button" class="btn btn-soft-danger btn-sm" data-bs-toggle="modal"
									data-bs-target="#delete-<?= $val->id;?>"><i class="bi-trash"></i></button>
							</td>
							<td><?= $val->kode;?></td>
							<td><?= $val->nama;?></td>
							<td><?= $val->jenis == 1 ? 'Rp.' : '%';?>
								<?= $val->jenis == 1 ? number_format($val->value, 0, ",", ".") : $val->value;?></td>
							<td>Rp. <?= !is_null($val->maksimal_promo) ? number_format($val->maksimal_promo, 0, ",", ".") : '-';?>
							</td>
							<td><?= $val->jenis == 1 ? 'Flat' : 'Presentage';?></td>
							<td><?= $val->quota;?></td>
							<td><span
									class="badge bg-<?= $val->status == 1 ? 'success' : 'danger';?>"><?= $val->status == 1 ? 'Aktif' : 'Tidak aktif';?></span>
							</td>
							<td><?= date("d F Y", $val->expired);?></td>
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
										<form action="<?= site_url('api/master/deletePromo');?>" method="post"
											class="js-validate need-validate" novalidate>
											<input type="hidden" name="id" value="<?= $val->id;?>">
											<p>Apakah kamu yakin ingin menghapus data <b><?= $val->nama;?></b> ini?</p>
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
						<?php endforeach;?>
						<?php endif;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="detailUserTitle">Ubah data</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="edit-content">

			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="detailUserTitle">Tambah Data</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('api/master/savePromo');?>" method="post" enctype="multipart/form-data"
					class="js-validate need-validate" novalidate>
					<div class="row">
						<div class="col-6">
							<div class="mb-3">
								<label for="inputJenisPromo" class="form-label">Jenis</label>
								<div class="tom-select-custom">
									<select class="js-select form-select form-select-sm" autocomplete="off" name="jenis"
										id="inputJenisPromo"
										data-hs-tom-select-options='{"placeholder": "Pilih jenis promo", "hideSearch": true}'
										required>
										<option value="">Pilih jenis promo</option>
										<option value="1">Flat</option>
										<option value="2">Presentage</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-6">
							<div class="mb-3">
								<label for="inputStatusPromo" class="form-label">Status</label>
								<div class="tom-select-custom">
									<select class="js-select form-select form-select-sm" autocomplete="off"
										name="status" id="inputStatusPromo"
										data-hs-tom-select-options='{"hideSearch": true}' required>
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
								<input class="form-control form-control-sm" type="text" name="nama"
									placeholder="Nama Promo" required>
							</div>
						</div>
						<div class="col-5">
							<div class="mb-3">
								<label for="inputSubject" class="form-label">Pengguna</label>
								<select class="js-select form-select form-select-sm" autocomplete="off"
									name="jenis_pengguna" id="inputJenisPenggunaPromo"
									data-hs-tom-select-options='{"hideSearch": true}' required>
									<option value="0">
										Semua Pengguna</option>
									<option value="1">
										Pengguna Baru</option>
								</select>
							</div>
						</div>
					</div>
					<div class="mb-3">
						<figure>
							<img src="#" id="promotambah-preview" class="img-thumbnail img-fluid" alt="Thumbnail image"
								onerror="this.onerror=null;this.src='<?= base_url();?><?= 'assets/images/placeholder.jpg'?>';">
						</figure>
						<label for="promotambah-upload" class="form-label">Gambar <small
								class="text-muted">(optional)</small>:</label>
						<div class="input-group">
							<input type="file" class="form-control form-control-sm imgprev" name="image"
								accept="image/*, .svg" id="promotambah-upload">
						</div>
						<small class="text-muted">Max file size 1Mb</small>
					</div>
					<div class="row">
						<div class="col-6">
							<div class="mb-3">
								<label for="inputKodePromo" class="form-label">Kode</label>
								<input class="form-control form-control-sm" id="inputKodePromo"
									onkeypress="return event.charCode >= 48" type="text" name="kode"
									placeholder="Kode promo" required>
							</div>
						</div>
						<div class="col-6">
							<div class="mb-3">
								<label for="inputNominalPromo" class="form-label">Nominal/Nilai</label>
								<div class="input-group input-group-sm flex-nowrap">
									<span class="input-group-text" id="addon-wrapping"><span
											id="symbol_promo">Rp</span></span>
									<input type="number" class="form-control form-controls-sm" id="value_promo"
										name="value" onkeypress="return event.charCode >= 48"
										placeholder="Nominal/Nilai Promo" required>
								</div>
							</div>
						</div>
						<div class="col-12" style="display:none" id="maksimal-nominal">
							<div class="mb-3">
								<label for="inputNominalPromo" class="form-label">Maksimal nominal promo</label>
								<div class="input-group input-group-sm flex-nowrap">
									<span class="input-group-text" id="addon-wrapping"><span
											id="symbol_promo">Rp</span></span>
									<input type="number" class="form-control form-controls-sm" name="maksimal_promo"
										onkeypress="return event.charCode >= 48" placeholder="Nominal/Nilai Promo"
										required>
								</div>
								<small class="text-secondary">Maksimal nominal promo digunakan untuk memberi batasan
									pemotongan berapa persen dari promo yang digunakan</small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<div class="mb-3">
								<label for="inputSubject" class="form-label">Berlaku Sampai</label>
								<input class="form-control form-control-sm" type="date" name="expired"
									placeholder="Berlaku sampai" required>
							</div>
						</div>
						<div class="col-6">
							<div class="mb-3">
								<label for="inputSubject" class="form-label">Batas penggunaan</label>
								<input class="form-control form-control-sm" type="number" min="0" max="9999"
									onkeypress="return event.charCode >= 48" name="quota" placeholder="∞ Unlimited"
									required>
								<small class="text-secondary">Kosongi untuk set ke tanpa bayas / unlimited.</small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="mb-3">
								<label for="inputKeterangan" class="form-label">Keterangan</label>
								<textarea name="desc" id="inputKeterangan" class="form-control form-control-sm" rows="3"
									placeholder="Keterangan promo"></textarea>
							</div>
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

<script>
	$("#inputJenisPromo").change(function (e) {
		e.preventDefault();
		var jenis_promo = $('#inputJenisPromo :selected').val();
		if (jenis_promo == 1) {
			$("#maksimal-nominal").hide();
			$("#value_promo").attr({
				"max": 9999999999,
				"min": 1
			});
			$('#symbol_promo').text('Rp');
		} else if (jenis_promo == 2) {
			$("#maksimal-nominal").show();
			$("#value_promo").attr({
				"max": 100,
				"min": 1
			});
			$('#symbol_promo').text('%');
		}

		$('#value_promo').on('keyup', function () {
			v = parseInt($(this).val());
			min = parseInt($(this).attr('min'));
			max = parseInt($(this).attr('max'));

			/*if (v < min){
			    $(this).val(min);
			} else */
			if (v > max) {
				$(this).val(max);
			}
		})
	});

	const showMdlPromoEdit = id => {
		$("#edit-content").html(
			`<center class="py-5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang memuat ...</center>`
		);

		$('#edit').modal('show')

		jQuery.ajax({
			url: "<?= site_url('ajax/master/getDetailPromo') ?>",
			type: 'POST',
			data: {
				promo_id: id
			},
			success: function (data) {
				$("#edit-content").html(data);
			}
		});
	}

</script>
