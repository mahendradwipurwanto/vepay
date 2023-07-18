<!-- Accordion -->
<div class="accordion" id="accordionExample">
	<div class="accordion-item">
		<div class="accordion-header mb-2" id="headingOne">
			<a class="accordion-button bg-primary text-white" role="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				Detail Transaksi
			</a>
		</div>
		<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
			<div class="accordion-body">
				<!-- List Striped -->
				<ul class="list-group list-group-lg">
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col-sm-4 mb-2 mb-sm-0">
								<span class="h6">ID Transaksi</span>
							</div>
							<!-- End Col -->

							<div class="col-sm-8 mb-2 mb-sm-0">
								<span><?= $transaksi->id; ?></span>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col-sm-4 mb-2 mb-sm-0">
								<span class="h6">Kode Transaksi</span>
							</div>
							<!-- End Col -->

							<div class="col-sm-8 mb-2 mb-sm-0">
								<span>#<?= $transaksi->kode; ?></span>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col-sm-4 mb-2 mb-sm-0">
								<span class="h6">Tipe</span>
							</div>
							<!-- End Col -->

							<div class="col-sm-8 mb-2 mb-sm-0">
								<span><?= $transaksi->type == 1 ? '<span class="badge bg-success">Cashback</span>' : '<span class="badge bg-warning">Withdraw</span>'; ?></span>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col-sm-4 mb-2 mb-sm-0">
								<span class="h6">Status Transaksi</span>
							</div>
							<!-- End Col -->

							<div class="col-sm-8 mb-2 mb-sm-0">
								<?php if ($transaksi->type == 2) : ?>
									<?php if ($transaksi->status == 0) : ?>
										<span class="badge bg-secondary">Pending</span>
									<?php elseif ($transaksi->status == 1) : ?>
										<span class="badge bg-success">Success</span>
									<?php elseif ($transaksi->status == 2) : ?>
										<span class="badge bg-danger">Rejected</span>
									<?php elseif ($transaksi->status == 3) : ?>
										<span class="badge bg-warning">Expired</span>
									<?php endif; ?>
								<?php else : ?>
									<?php if ($transaksi->status_withdraw == 1) : ?>
										<span class="badge bg-secondary">Pending</span>
									<?php elseif ($transaksi->status_withdraw == 2) : ?>
										<span class="badge bg-success">Success</span>
									<?php elseif ($transaksi->status_withdraw == 3) : ?>
										<span class="badge bg-danger">Rejected</span>
									<?php elseif ($transaksi->status_withdraw == 4) : ?>
										<span class="badge bg-warning">Expired</span>
									<?php endif; ?>
								<?php endif; ?>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col-sm-4 mb-2 mb-sm-0">
								<span class="h6">Tanggal <?= $transaksi->type == 1 ? 'Cashback' : 'Withdraw'; ?></span>
							</div>
							<!-- End Col -->

							<div class="col-sm-8 mb-2 mb-sm-0">
								<span><?= date("d F Y", $transaksi->created_at); ?></span>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col-sm-4 mb-2 mb-sm-0">
								<span class="h6">Member/Pelanggan</span>
							</div>
							<!-- End Col -->

							<div class="col-sm-8 mb-2 mb-sm-0">
								<span><?= $transaksi->name; ?></span>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>

					<li class="list-group-item p-3">
						<div class="row">
							<div class="col-sm-4 mb-2 mb-sm-0">
								<span class="h6">Metode Pembayaran</span>
							</div>
							<!-- End Col -->

							<div class="col-sm-8 mb-2 mb-sm-0">
								<span><?= $transaksi->metode; ?></span>
								<img src="<?= base_url(); ?><?= $transaksi->img_metode; ?>" alt="<?= $transaksi->metode; ?>" onerror="this.onerror=null;this.src='<?= base_url(); ?><?= 'assets/images/placeholder.jpg' ?>';" style="width: 65px; margin-left: 5px;">
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>
					<?php if (!is_null($transaksi->rekening_tujuan)) : ?>
						<li class="list-group-item p-3">
							<div class="row">
								<div class="col-sm-4 mb-2 mb-sm-0">
									<span class="h6">No rekening/ No Ewallet</span>
								</div>
								<!-- End Col -->

								<div class="col-sm-8 mb-2 mb-sm-0">
									<span><?= $transaksi->rekening_tujuan; ?></span>
								</div>
								<!-- End Col -->
							</div>
							<!-- End Row -->
						</li>
					<?php endif; ?>
					<?php if (isset($transaksi->atas_nama) && !is_null($transaksi->atas_nama)) : ?>
						<li class="list-group-item p-3">
							<div class="row">
								<div class="col-sm-4 mb-2 mb-sm-0">
									<span class="h6">Atas Nama</span>
								</div>
								<!-- End Col -->

								<div class="col-sm-8 mb-2 mb-sm-0">
									<span><?= $transaksi->atas_nama; ?></span>
								</div>
								<!-- End Col -->
							</div>
							<!-- End Row -->
						</li>
					<?php endif; ?>
					<!-- END BLOCKCHAIN -->
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col-sm-4 mb-2 mb-sm-0">
								<span class="h6">Whatsapp Pelanggan</span>
							</div>
							<!-- End Col -->

							<div class="col-sm-8 mb-2 mb-sm-0">
								<span><?= $transaksi->phone == "" ? '<span class="badge bg-warning">Belum mengatur nomor</span>' : $transaksi->phone; ?></span>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>
					<li class="list-group-item p-3">
						<div class="row">
							<div class="col-sm-4 mb-2 mb-sm-0">
								<span class="h6">Total <?= $transaksi->type == 1 ? 'Cashback' : 'Withdraw'; ?></span>
							</div>
							<!-- End Col -->

							<div class="col-sm-8 mb-2 mb-sm-0">
								<span>Rp <?= number_format($transaksi->nominal); ?></span>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="accordion-item">
		<div class="accordion-header mb-2" id="headingThree">
			<a class="accordion-button bg-primary text-white collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				Bukti verifikasi transfer
			</a>
		</div>
		<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
			<div class="accordion-body">
				<!-- List Striped -->
				<ul class="list-group list-group-lg">
					<li class="list-group-item p-3">
						<div class="row d-flex justify-content-center">
							<div class="col-sm-6 mb-2 mb-sm-0">
								<figure class="text-center mb-2 image-container">
									<img id="imgthumbnail" class="img-thumbnail img-fluid w-100" alt="Thumbnail image" src="<?= base_url(); ?><?= isset($transaksi->bukti) ? $transaksi->bukti : 'assets/images/placeholder.jpg'; ?>">
									<div class="loading-overlay"></div>
								</figure>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</li>
				</ul>
				<!-- End List Striped -->
			</div>
		</div>
	</div>
</div>
<!-- End Accordion -->

<script>
	function handleImageLoading() {
		const imageContainers = document.querySelectorAll('.image-container');

		imageContainers.forEach(container => {
			const image = container.querySelector('img');
			const overlay = container.querySelector('.loading-overlay');

			overlay.style.opacity = '1';

			image.onerror = function() {
				// Replace the image source with the placeholder image URL
				image.src = 'https://fakeimg.pl/600x400?text=app.vepay.id&font=lobster';
				image.style.visibility = 'visible';
				overlay.style.opacity = '0';
			};

			image.onload = function() {
				overlay.style.opacity = '0';
				image.style.visibility = 'visible';
			};
		});
	}

	// Call the function when needed, such as after an AJAX request
	handleImageLoading();
</script>