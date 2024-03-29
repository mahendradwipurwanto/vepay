<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Master metode
				<button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
					data-bs-target="#tambah"><i class="bi bi-tag"></i> Tambah data</button>
			</h1>
			<p class="docs-page-header-text">Kelola master metode pada website anda</p>
		</div>
	</div>
</div>
<!-- End Page Header -->


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-borderless table-thead-bordered nowrap w-100 align-middle dataTables" id="table">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="8%"></th>
							<th>Metode</th>
							<th>Atas Nama/Email</th>
							<th>No. Rek/Telepon</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($metode)):?>
						<?php $no = 1; foreach($metode as $val):?>
						<tr>
							<td><?= $no++;?></td>
							<td>
								<button type="button" class="btn btn-soft-info btn-sm" onclick="showMdlMetodeEdit(<?= $val->id;?>)"><i class="bi-pencil-square"></i></button>
								<button type="button" class="btn btn-soft-danger btn-sm" data-bs-toggle="modal"
									data-bs-target="#delete-<?= $val->id;?>"><i class="bi-trash"></i></button>
							</td>
							<td><?= $val->metode;?></td>
							<td><?= $val->atas_nama;?></td>
							<td><?= $val->no_rekening;?></td>
							<td><?= $val->description;?></td>
						</tr>

						<div id="delete-<?= $val->id; ?>" class="modal fade" tabindex="-1" role="dialog"
							aria-labelledby="delete" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered modal-sm"
								role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="detailUserTitle">Hapus data</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<form action="<?= site_url('api/master/deleteMetode');?>" method="post"
											class="js-validate need-validate" novalidate>
											<input type="hidden" name="id" value="<?= $val->id;?>">
											<p>Apakah kamu yakin ingin menghapus data <?= $val->metode;?> ini?</p>
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
<div id="tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="detailUserTitle">Tambah Data</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('api/master/saveMetode');?>" method="post" enctype="multipart/form-data"
					class="js-validate need-validate" novalidate>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Metode</label>
						<input class="form-control form-control-sm" type="text" name="metode"
							placeholder="Ketikkan metode" required>
					</div>
					<div class="mb-3">
						<figure>
							<img src="#" id="metodeTambah-preview" class="img-thumbnail img-fluid" alt="Thumbnail image"
								onerror="this.onerror=null;this.src='<?= base_url();?><?= 'assets/images/placeholder.jpg'?>';">
						</figure>
						<label for="metodeTambah-upload" class="form-label">Gambar <small
								class="text-muted">(optional)</small>:</label>
						<div class="input-group">
							<input type="file" class="form-control form-control-sm imgprev" name="image"
								accept="image/*, .svg" id="metodeTambah-upload">
						</div>
						<small class="text-muted">Max file size 1Mb</small>
					</div>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Atas nama/Email/Nama Akun</label>
						<input class="form-control form-control-sm" type="text" name="atas_nama"
							placeholder="Ketikkan atas nama" required>
					</div>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">No Rekening/No Akun/No Telepon</label>
						<input class="form-control form-control-sm" type="text" name="no_rekening"
							placeholder="Ketikkan nomor rekening" required>
					</div>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Keterangan <small
								class="text-secondary">(optional)</small></label>
						<textarea class="form-control form-control-sm" type="text" name="description"
							placeholder="Ketikkan keterangan"></textarea>
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

<!-- Modal -->
<div id="edit" class="modal fade" tabindex="-1" role="dialog"
	aria-labelledby="add" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="detailUserTitle">Ubah data</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close"></button>
			</div>
			<div class="modal-body" id="edit-content">
			</div>
		</div>
	</div>
</div>

<script>
	
	const showMdlMetodeEdit = id => {
		$("#edit-content").html(
			`<center class="py-5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang memuat ...</center>`
		);

		$('#edit').modal('show')

		jQuery.ajax({
			url: "<?= site_url('ajax/master/getDetailMetode') ?>",
			type: 'POST',
			data: {
				metode_id: id
			},
			success: function (data) {
				$("#edit-content").html(data);
			}
		});
	}
</script>
