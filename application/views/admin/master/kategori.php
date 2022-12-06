<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Master kategori
				<button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
					data-bs-target="#tambah"><i class="bi bi-tag"></i> Tambah data</button>
			</h1>
			<p class="docs-page-header-text">Kelola master kategori pada website anda</p>
		</div>
	</div>
</div>
<!-- End Page Header -->


<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<table class="table table-hover table-striped w-100 dataTables" id="table">
					<thead>
						<tr>
							<th width="10%">No.</th>
							<th width="25%"></th>
							<th>Kategori</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($kategori)):?>
						<?php $no = 1; foreach($kategori as $val):?>
						<tr>
							<td><?= $no++;?></td>
							<td>
								<button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal"
									data-bs-target="#edit-<?= $val->id;?>"><i class="bi-pencil-square"></i></button>
								<button type="button" class="btn btn-soft-danger btn-sm" data-bs-toggle="modal"
									data-bs-target="#delete-<?= $val->id;?>"><i class="bi-trash"></i></button>
							</td>
							<td><?= $val->categories;?></td>
							<td><?= $val->description;?></td>
						</tr>

						<!-- Modal -->
						<div id="edit-<?= $val->id;?>" class="modal fade" tabindex="-1" role="dialog"
							aria-labelledby="add" aria-hidden="true">
							<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="detailUserTitle">Ubah data</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<form action="<?= site_url('api/master/saveKategori');?>" method="post"
											enctype="multipart/form-data" class="js-validate need-validate" novalidate>
											<input type="hidden" name="id" value="<?= $val->id;?>" required>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Kategori</label>
												<input class="form-control form-control-sm" type="text"
													name="categories" value="<?= $val->categories;?>" required>
											</div>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Keterangan <small
														class="text-secondary">(optional)</small></label>
												<textarea class="form-control form-control-sm" type="text"
													name="description"><?= $val->description;?></textarea>
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

						<div id="delete-<?= $val->id; ?>" class="modal fade" tabindex="-1" role="dialog"
							aria-labelledby="delete" aria-hidden="true">
							<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
								role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="detailUserTitle">Hapus data</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<form action="<?= site_url('api/master/deleteKategori');?>" method="post"
											class="js-validate need-validate" novalidate>
											<input type="hidden" name="id" value="<?= $val->id;?>">
											<p>Apakah kamu yakin ingin menghapus data <?= $val->categories;?> ini?</p>
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
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="detailUserTitle">Tambah Data</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('api/master/saveKategori');?>" method="post" enctype="multipart/form-data"
					class="js-validate need-validate" novalidate>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Kategori</label>
						<input class="form-control form-control-sm" type="text" name="categories"
							placeholder="Ketikkan kategori" required>
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
