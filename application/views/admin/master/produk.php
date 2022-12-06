<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Produk
				<div class="btn-group float-end">
					<button class="btn btn-sm btn-success dropdown-toggle" type="button"
						id="dropdownMenuButtonClickAnimation" data-bs-toggle="dropdown" aria-expanded="false"
						data-bs-dropdown-animation>
						<i class="bi-file-earmark-excel-fill"></i>&nbsp;
						Export
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClickAnimation">
						<a class="dropdown-item" href="<?= site_url('api/excel/exportProduk/1')?>">All</a>
					</div>
				</div>
			</h1>
			<p class="docs-page-header-text">Kelola semua informasi mengenai produk anda.</p>
		</div>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header py-3">
				<h4 class="card-header-title">Filter data produk</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Nama</label>
						<input type="text" id="filter_name" class="form-control form-control-sm"
							placeholder="Filter nama">
					</div>

					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Harga</label>
						<input type="text" id="filter_price" class="form-control form-control-sm"
							placeholder="Filter harga" />
					</div>

					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Kategori</label>
						<div class="tom-select-custom">
							<select class="js-select form-select form-select-sm" id="filter_categories"
								autocomplete="off" data-hs-tom-select-options='{"placeholder": "Semua kategori"}'>
								<option value="0">Semua kategori</option>
								<?php if(!empty($kategori)):?>
								<?php foreach($kategori as $key => $val):?>
								<option value="<?= $val->id;?>"><?= $val->categories;?></option>
								<?php endforeach;?>
								<?php endif;?>
							</select>
						</div>
					</div>
					<div class="col-sm mb-2 mb-sm-0">
						<button class="btn btn-sm btn-soft-info mt-4 me-1" type="button" id="searchBtn"
							onclick="btnSearch()"><i class="bi-search"></i>&nbsp&nbspPencarian</button>
						<button class="btn btn-sm btn-soft-primary mt-4" type="button" data-bs-toggle="modal"
							data-bs-target="#tambah"><i class="bi bi-person-plus"></i> Tambah produk</button>
					</div>
				</div>
			</div>
			<div class="card-header py-3">
				<h4 class="card-header-title">Data produk</h4>
			</div>
			<div class="card-body">
				<!-- End Row -->
				<table id="dataTable" class="table table-borderless table-thead-bordered nowrap w-100 align-middle">
					<thead class="thead-light">
						<tr>
							<th width="5%" scope="col">No</th>
							<th width="15%" scope="col"></th>
							<th scope="col">Nama</th>
							<th scope="col">Harga</th>
							<th scope="col">Kategori</th>
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
				<h5 class="modal-title" id="mdlDeleteLabel">Tambah Produk</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('api/master/addProduct');?>" method="post"
					class="js-validate need-validate m-0" novalidate enctype="multipart/form-data">
					<div class="mb-3">
						<div class="js-form-message">
							<label for="inputName" class="form-label">Nama produk</label>
							<input type="text" name="name" id="inputName" class="form-control form-control-sm"
								placeholder="Nama produk" required>
							<span class="invalid-feedback">Harap masukkan nama produk yang valid.</span>
						</div>
					</div>
					<div class="mb-3">
						<figure>
							<img src="#" id="imgthumbnail" class="img-thumbnail img-fluid" alt="Thumbnail image"
								onerror="this.onerror=null;this.src='<?= base_url();?><?= 'assets/images/placeholder.jpg'?>';">
						</figure>
						<label for="poster-product" class="form-label">Gambar <small
								class="text-muted">(optional)</small>:</label>
						<div class="input-group">
							<input type="file" class="form-control imgprev" name="image" accept="image/*"
								id="poster-product">
						</div>
						<small class="text-muted">Max file size 1Mb</small>
					</div>
					<div class="mb-3">
						<div class="js-form-message">
							<label for="inputKategori" class="form-label">Kategori <small
									class="text-secondary">(optional)</small></label>
							<div class="tom-select-custom">
								<select class="js-select form-select form-select-sm" name="categories"
									autocomplete="off" data-hs-tom-select-options='{"placeholder": "Pilih kategori"}'>
									<?php if(!empty($kategori)):?>
									<?php foreach($kategori as $key => $val):?>
									<option value="<?= $val->id;?>"><?= $val->categories;?></option>
									<?php endforeach;?>
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
									placeholder="Harga" onkeypress="return isNumberKey(event)" required>
								<span class="input-group-text" id="basic-addon1">per satuan</span>
							</div>
							<span class="invalid-feedback">Harap masukkan harga yang valid.</span>
						</div>
					</div>
					<div class="mb-3">
						<div class="js-form-message">
							<label for="inputDescription" class="form-label">Deskripsi <small
									class="text-secondary">(optional)</small></label>
							<textarea type="text" id="inputDescription" name="description"
								class="form-control form-control-sm" placeholder="Deskripsi" rows="3"></textarea>
							<span class="invalid-feedback">Harap masukkan deskripsi yang valid.</span>
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
<div class="modal fade" id="mdlProductDetail" aria-labelledby="mdlDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mdlDeleteLabel">Detail produk</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="modalProductContent">
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div class="modal fade" id="mdlProductDelete" tabindex="-1" aria-labelledby="mdlDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mdlDeleteLabel">Hapus produk</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
				<div class="mb-2">Apakah anda yakin ingin menghapus produk ini?
				</div>
				<div class="modal-footer p-0 pt-2 m-0">
					<form action="<?= site_url('api/master/deleteProduct')?> " method="post"
						class="js-validate need-validate m-0" novalidate>
						<input type="hidden" name="id" id="mdlProduct_id">
						<button type="button" class="btn btn-outline-secondary btn-sm"
							data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-soft-danger btn-sm">Hapus</button>
					</form>
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
				'url': "<?= site_url('ajax/master/getAjaxProduct')?>",
				'data': function (d) {
					d.filterEmail = $('#filter_email').val()
					d.filterName = $('#filter_name').val()
					d.filterCategories = $('#filter_categories').val()
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
					data: 'name'
				},
				{
					data: 'price'
				},
				{
					data: 'categories'
				}
			]
		});
		const showMdlProductDetail = id => {
			$("#modalProductContent").html(
				`<center class="py-5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang memuat ...</center>`
			);

			$('#mdlProductDetail').modal('show')

			jQuery.ajax({
				url: "<?= site_url('ajax/master/getDetailProduct') ?>",
				type: 'POST',
				data: {
					product_id: id
				},
				success: function (data) {
					$("#modalProductContent").html(data);
				}
			});
		}

		const showMdlProductDelete = id => {
			$('#mdlProduct_id').val(id);
			$('#mdlProductDelete').modal('show')
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
