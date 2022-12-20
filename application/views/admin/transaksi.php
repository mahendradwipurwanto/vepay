<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Transaksi
				<div class="btn-group float-end">
					<button class="btn btn-sm btn-success dropdown-toggle" type="button"
						id="dropdownMenuButtonClickAnimation" data-bs-toggle="dropdown" aria-expanded="false"
						data-bs-dropdown-animation>
						<i class="bi-file-earmark-excel-fill"></i>&nbsp;
						Export
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClickAnimation">
						<a class="dropdown-item" href="<?= site_url('api/excel/exportTransaksi/1')?>">All</a>
					</div>
				</div>
			</h1>
			<p class="docs-page-header-text">Kelola semua informasi mengenai transaksi anda.</p>
		</div>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header py-3">
				<h4 class="card-header-title">Filter data transaksi</h4>
			</div>
			<div class="card-body">
				<div class="row mb-4">
					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Email</label>
						<input type="text" id="filter_email" class="form-control form-control-sm"
							placeholder="Filter email" />
					</div>

					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Nama</label>
						<input type="text" id="filter_name" class="form-control form-control-sm"
							placeholder="Filter nama">
					</div>

					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Nomor Whatsapp</label>
						<input type="text" id="filter_number" class="form-control form-control-sm"
							placeholder="Filter whatsapp">
					</div>
				</div>
				<div class="row">
					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Kode Transaksi</label>
						<input type="text" id="filter_kode" class="form-control form-control-sm"
							placeholder="Filter kode transaksi" />
					</div>

					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Metode</label>
						<div class="tom-select-custom">
							<select class="js-select form-select form-select-sm" autocomplete="off" id="filter_metode"
								name="metode" data-hs-tom-select-options='{"placeholder": "Produk...", "hideSearch": true}'>
                                <option value="0">Semua metode</option>
								<?php if(!empty($metode)):?>
								<?php foreach ($metode as $key => $val):?>
								<option value="<?= $val->id;?>"><?= $val->metode;?></option>
								<?php endforeach;?>
								<?php endif;?>
							</select>
						</div>
					</div>
					<div class="col-sm mb-2 mb-sm-0">
						<button class="btn btn-sm btn-soft-info mt-4 me-1" type="button" id="searchBtn"
							onclick="btnSearch()"><i class="bi-search"></i>&nbsp&nbspPencarian</button>
						<button class="btn btn-sm btn-soft-primary mt-4" type="button" data-bs-toggle="modal"
							data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah transaksi</button>
					</div>
				</div>
			</div>
			<div class="card-header py-3">
				<h4 class="card-header-title">Data transaksi</h4>
			</div>
			<div class="card-body">
				<!-- End Row -->
				<table id="dataTable" class="table table-borderless table-thead-bordered nowrap w-100 align-middle">
					<thead class="thead-light">
						<tr>
							<th scope="col">No</th>
							<th scope="col"></th>
							<th scope="col">Kode</th>
							<th scope="col">Nama</th>
							<th scope="col">Metode</th>
							<th scope="col">Produk</th>
							<th scope="col">Total</th>
							<th scope="col">Status</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="mdlDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mdlDeleteLabel">Tambah Transaksi</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('api/transaksi/addTransaksi');?>" method="post"
					class="js-validate need-validate" novalidate enctype="multipart/form-data">
					<div class="mb-3">
						<div class="js-form-message">
							<label for="inputMember" class="form-label">Member</label>
							<div class="tom-select-custom">
								<select class="js-select form-select form-select-sm" autocomplete="off" id="inputMember"
									name="member" data-hs-tom-select-options='{"placeholder": "Member...", "hideSearch": true}'>
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
					<div class="row mb-3">
						<div class="col-8">
							<div class="js-form-message">
								<label for="inputProduk" class="form-label">Produk</label>
								<div class="tom-select-custom">
									<select class="js-select form-select form-select-sm" autocomplete="off"
										id="inputProduk" name="produk"
										data-hs-tom-select-options='{"placeholder": "Produk...", "hideSearch": true}'>
										<?php if(!empty($product)):?>
										<?php foreach ($product as $key => $val):?>
										<option value="<?= $val->id;?>"><b><?= $val->name;?></b> -
											<i><?= $val->type;?></i></option>
										<?php endforeach;?>
										<?php endif;?>
									</select>
								</div>
								<span class="invalid-feedback">Harap masukkan produk yang valid.</span>
							</div>
						</div>
						<div class="col-4">
							<div class="js-form-message">
								<label for="inputJumlah" class="form-label">Jumlah</label>
								<input type="text" name="jumlah" id="inputJumlah" class="form-control form-control-sm"
									placeholder="jumlah" required>
								<span class="invalid-feedback">Harap masukkan jumlah yang valid.</span>
							</div>
						</div>
					</div>
					<div class="mb-3">
						<div class="js-form-message">
							<label for="inputMetode" class="form-label">Metode</label>
							<div class="tom-select-custom">
								<select class="js-select form-select form-select-sm" autocomplete="off" id="inputMetode"
									name="metode" data-hs-tom-select-options='{"placeholder": "Metode pembayaran...", "hideSearch": true}'>
									<?php if(!empty($metode)):?>
									<?php foreach ($metode as $key => $val):?>
									<option value="<?= $val->id;?>"><?= $val->metode;?></option>
									<?php endforeach;?>
									<?php endif;?>
								</select>
							</div>
							<span class="invalid-feedback">Harap masukkan metode yang valid.</span>
						</div>
					</div>
					<hr>
					<h3>Detail Pembayaran</h3>
					<div class="mb-3">
						<div class="js-form-message">
							<label for="inputAccount" class="form-label">Akun</label>
							<input type="text" name="account" id="inputAccount" class="form-control form-control-sm"
								placeholder="Akun" required>
							<span class="invalid-feedback">Harap masukkan data akun yang valid.</span>
						</div>
						<small class="text-secondary">Akun yang dituju sesuai produk (email paypal, ID Payeer, Address
							BITCOIN, dll)</small>
					</div>
					<div class="mb-3">
						<figure>
							<img src="#" id="imgthumbnail" class="img-thumbnail img-fluid" alt="Thumbnail image"
								onerror="this.onerror=null;this.src='<?= base_url();?><?= 'assets/images/placeholder.jpg'?>';">
						</figure>
						<label for="poster-product" class="form-label">Bukti Pembayaran <small
								class="text-muted">(optional)</small>:</label>
						<div class="input-group">
							<input type="file" class="form-control form-control-sm imgprev" name="image"
								accept="image/*" id="poster-product">
						</div>
						<small class="text-muted">Max file size 1Mb. Anda dapat melawati field ini jika pembayaran dalam
							proses</small>
					</div>
					<div class="mb-3">
						<div class="js-form-message">
							<label for="inputCatatan" class="form-label">Catatan <small
									class="text-muted">(optional)</small></label>
							<textarea type="text" id="inputCatatan" name="notes" class="form-control form-control-sm"
								placeholder="Catatan" rows="3" required></textarea>
							<span class="invalid-feedback">Harap masukkan Catatan yang valid.</span>
						</div>
					</div>

					<div class="modal-footer p-0 pt-3">
						<button type="button" class="btn btn-outline-secondary btn-sm"
							data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-soft-primary btn-sm">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade" id="mdlTransDetail" tabindex="-1" aria-labelledby="mdlDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mdlDeleteLabel">Detail Transaksi</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="modalTransContent">
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade" id="mdlTransVerif" tabindex="-1" aria-labelledby="mdlDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mdlDeleteLabel">Verifikasi Transaksi</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="modalTransVerif">
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<script>
	var table = $('#dataTable').DataTable({
		'processing': true,
		'serverSide': true,
		'destroy': true,
		'ordering': false,
		'searching': false,
		'scrollX': true,
		'responsive': true,
		'serverMethod': 'post',
		'ajax': {
			'url': "<?= site_url('ajax/transaksi/getAjaxTransaksi')?>",
			'data': function (d) {
				d.filterEmail = $('#filter_email').val()
				d.filterName = $('#filter_name').val()
				d.filterNumber = $('#filter_number').val()
				d.filterKode = $('#filter_kode').val()
				d.filterProduk = $('#filter_produk').val()
				d.filterMetode = $('#filter_metode').val()
			},
			'dataSrc': function (json) {
				doneLoading();
				return json.data;
			}
		},
		'columns': [{
				data: 'no'
			},
			{
				data: 'action'
			},
			{
				data: 'kode'
			},
			{
				data: 'name'
			},
			{
				data: 'metode'
			},
			{
				data: 'produk'
			},
			{
				data: 'total'
			},
			{
				data: 'status'
			}
		]
	});

	const showMdlTransDetail = id => {
		$("#modalTransContent").html(
			`<center class="py-5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang memuat ...</center>`
		);

		$('#mdlTransDetail').modal('show')

		jQuery.ajax({
			url: "<?= site_url('ajax/transaksi/getDetailTrans') ?>",
			type: 'POST',
			data: {
				transaksi_id: id
			},
			success: function (data) {
				$("#modalTransContent").html(data);
			}
		});
	}

	const showMdlTransVerif = id => {
		$("#modalTransContent").html(
			`<center class="py-5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang memuat ...</center>`
		);

		$('#mdlTransVerif').modal('show')

		jQuery.ajax({
			url: "<?= site_url('ajax/transaksi/getVerifTrans') ?>",
			type: 'POST',
			data: {
				transaksi_id: id
			},
			success: function (data) {
				$("#modalTransVerif").html(data);
			}
		});
	}

	function doneLoading() {
		$('#searchBtn').prop("disabled", false);
		// add spinner to button
		$('#searchBtn').html(
			`<i class="bi-search"></i>&nbsp&nbspSearch`
		);
	}

	function btnSearch() {
		$('#searchBtn').prop("disabled", true);
		// add spinner to button
		$('#searchBtn').html(
			`<span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span> loading...`
		);

		table.ajax.reload();
	}

</script>
