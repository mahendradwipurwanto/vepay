<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Master faq
				<button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
					data-bs-target="#tambah"><i class="bi bi-tag"></i> Tambah data</button>
			</h1>
			<p class="docs-page-header-text">Kelola master faq pada website anda</p>
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
							<th>Judul</th>
							<th>Keterangan</th>
							<th>Terakhir diubah pada</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!empty($faq)):?>
						<?php $no = 1; foreach($faq as $val):?>
						<tr>
							<td><?= $no++;?></td>
							<td>
								<button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal"
									data-bs-target="#edit-<?= $val->id;?>"><i class="bi-pencil-square"></i></button>
								<button type="button" class="btn btn-soft-danger btn-sm" data-bs-toggle="modal"
									data-bs-target="#delete-<?= $val->id;?>"><i class="bi-trash"></i></button>
							</td>
							<td><?= $val->judul;?></td>
							<td>
								<button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal"
									data-bs-target="#detail-<?= $val->id;?>">deskripsi</button>
							</td>
							<td><?= is_null($val->modified_at) ? date("d F Y, H:i", $val->created_at) : date("d F Y, H:i", $val->modified_at);?>
							</td>
						</tr>

						<!-- Modal -->
						<div id="edit-<?= $val->id;?>" class="modal fade" tabindex="-1" role="dialog"
							aria-labelledby="add" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="detailUserTitle">Ubah data</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<form action="<?= site_url('api/master/saveFaq');?>" method="post"
											enctype="multipart/form-data" class="js-validate need-validate" novalidate>
											<input type="hidden" name="id" value="<?= $val->id;?>" required>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Judul</label>
												<input class="form-control form-control-sm" type="text" name="judul"
													value="<?= $val->judul;?>" required>
											</div>

											<div class="mb-3">
												<label for="inputSubject" class="form-label">Keterangan <small
														class="text-secondary">(optional)</small></label>
												<textarea class="form-control form-control-sm editor" type="text"
													id="editor-<?= $val->id;?>"
													name="deskripsi"><?= $val->deskripsi;?></textarea>
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

						<div id="detail-<?= $val->id; ?>" class="modal fade" tabindex="-1" role="dialog"
							aria-labelledby="detail" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="detailUserTitle">Hapus data</h4>
										<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<?= $val->deskripsi;?>
									</div>
								</div>
							</div>
						</div>

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
										<form action="<?= site_url('api/master/deleteFaq');?>" method="post"
											class="js-validate need-validate" novalidate>
											<input type="hidden" name="id" value="<?= $val->id;?>">
											<p>Apakah kamu yakin ingin menghapus data <?= $val->judul;?> ini?</p>
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
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="detailUserTitle">Tambah Data</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('api/master/saveFaq');?>" method="post" enctype="multipart/form-data"
					class="js-validate need-validate" novalidate>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Judul</label>
						<input class="form-control form-control-sm" type="text" name="judul" placeholder="Ketikkan faq"
							required>
					</div>

					<div class="mb-3">
						<label for="inputSubject" class="form-label">Keterangan <small
								class="text-secondary">(optional)</small></label>
						<textarea class="form-control form-control-sm editor" type="text" name="deskripsi" id="editor"
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


<script>
	//  ckeditor
	$('textarea.editor').each(function () {
		CKEDITOR.replace($(this).attr('id'), {
			toolbar: [{
					name: 'basicstyles',
					items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']
				},
				{
					name: 'paragraph',
					items: ['NumberedList', 'BulletedList', '-',
						'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight',
						'JustifyBlock'
					]
				},
				{
					name: 'links',
					items: ['Link', 'Unlink']
				},
				{
					name: 'insert',
					items: ['Image', 'Smiley', 'SpecialChar', 'Iframe']
				},
				{
					name: 'styles',
					items: ['Styles', 'Format', 'Font', 'FontSize']
				},
				{
					name: 'colors',
					items: ['TextColor', 'BGColor']
				}
			]
		});

	});

</script>
