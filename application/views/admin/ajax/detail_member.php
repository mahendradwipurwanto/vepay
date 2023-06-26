<div class="row">
	<div class="col-12">
		<!-- List Striped -->
		<!-- Step Form -->
		<form class="js-step-form"
			data-hs-step-form-options='{"progressSelector": "#basicVerStepFormProgress","stepsSelector": "#basicVerStepFormContent"}'>
			<div class="row">
				<div class="col-lg-3">
					<!-- Step -->
					<ul id="basicVerStepFormProgress" class="js-step-progress step step-icon-sm mb-7">
						<li class="step-item">
							<a class="step-content-wrapper" href="javascript:;"
								data-hs-step-form-next-options='{"targetSelector": "#dataPribadi"}'>
								<span class="step-icon step-icon-soft-dark">1</span>
								<div class="step-content pb-5">
									<span class="step-title mt-2">Data pribadi</span>
								</div>
							</a>
						</li>

						<li class="step-item">
							<a class="step-content-wrapper" href="javascript:;"
								data-hs-step-form-next-options='{"targetSelector": "#riwayatTransaksi"}'>
								<span class="step-icon step-icon-soft-dark stepy-last">2</span>
								<div class="step-content pb-5">
									<span class="step-title mt-2">Riwayat transaksi</span>
								</div>
							</a>
						</li>

						<!-- <li class="step-item">
							<a class="step-content-wrapper" href="javascript:;"
								data-hs-step-form-next-options='{"targetSelector": "#aksesLog"}'>
								<span class="step-icon step-icon-soft-dark stepy-last">3</span>
								<div class="step-content pb-5">
									<span class="step-title mt-2">Akses log</span>
								</div>
							</a>
						</li> -->
					</ul>
					<!-- End Step -->
				</div>

				<div class="col-lg-9">
					<!-- Content Step Form -->
					<div id="basicVerStepFormContent">
						<div id="dataPribadi" class="active" style="min-height: 15rem;">
							<!-- List Striped -->
							<ul class="list-group list-group-lg">
								<li class="list-group-item p-2 active">
									<span style="margin-top: -20px; margin-left: 5px" class="fw-bold">Data
										pribadi</span>
								</li>
								<li class="list-group-item p-3">
									<div class="row">
										<div class="col-sm-4 mb-2 mb-sm-0">
											<span class="h6">Status akun</span>
										</div>
										<!-- End Col -->

										<div class="col-sm-8 mb-2 mb-sm-0">
											<span><?= $member->status;?></span>
										</div>
										<!-- End Col -->
									</div>
									<!-- End Row -->
								</li>
								<li class="list-group-item p-3">
									<div class="row">
										<div class="col-sm-4 mb-2 mb-sm-0">
											<span class="h6">Email</span>
										</div>
										<!-- End Col -->

										<div class="col-sm-8 mb-2 mb-sm-0">
											<span><?= $member->email;?></span>
										</div>
										<!-- End Col -->
									</div>
									<!-- End Row -->
								</li>
								<li class="list-group-item p-3">
									<div class="row">
										<div class="col-sm-4 mb-2 mb-sm-0">
											<span class="h6">Bergabung pada</span>
										</div>
										<!-- End Col -->

										<div class="col-sm-8 mb-2 mb-sm-0">
											<span><?= $member->joined_at;?></span>
										</div>
										<!-- End Col -->
									</div>
									<!-- End Row -->
								</li>
								<li class="list-group-item p-3">
									<div class="row">
										<div class="col-sm-4 mb-2 mb-sm-0">
											<span class="h6">Nama lengkap</span>
										</div>
										<!-- End Col -->

										<div class="col-sm-8 mb-2 mb-sm-0">
											<span><?= $member->name;?></span>
										</div>
										<!-- End Col -->
									</div>
									<!-- End Row -->
								</li>
								<li class="list-group-item p-3">
									<div class="row">
										<div class="col-sm-4 mb-2 mb-sm-0">
											<span class="h6">Nomor Whatsapp</span>
										</div>
										<!-- End Col -->

										<div class="col-sm-8 mb-2 mb-sm-0">
											<span><?= $member->whatsapp;?></span>
										</div>
										<!-- End Col -->
									</div>
									<!-- End Row -->
								</li>
								<li class="list-group-item p-3">
									<div class="row">
										<div class="col-sm-4 mb-2 mb-sm-0">
											<span class="h6">Jenis kelamin</span>
										</div>
										<!-- End Col -->

										<div class="col-sm-8 mb-2 mb-sm-0">
											<span><?= $member->gender;?></span>
										</div>
										<!-- End Col -->
									</div>
									<!-- End Row -->
								</li>
								<li class="list-group-item p-3">
									<div class="row">
										<div class="col-sm-4 mb-2 mb-sm-0">
											<span class="h6">Alamat</span>
										</div>
										<!-- End Col -->

										<div class="col-sm-8 mb-2 mb-sm-0">
											<span><?= $member->address;?></span>
										</div>
										<!-- End Col -->
									</div>
									<!-- End Row -->
								</li>
							</ul>
							<!-- End List Striped -->
						</div>

						<div id="riwayatTransaksi" class="" style="display: none; min-height: 15rem;">
							<!-- List Striped -->
							<ul class="list-group list-group-lg">
								<li class="list-group-item p-2 active">
									<span style="margin-top: -20px; margin-left: 5px" class="fw-bold">Riwayat transaksi
										member</span>
								</li>
								<div style="max-height: 300px; overflow-y: auto;">
									<?php if(!empty($transaksi)):?>
									<?php foreach($transaksi as $key => $val):?>
										<li class="list-group-item p-3">
											<div class="row">
												<div class="col-sm-8 mb-2 mb-sm-0">
													<span><?= $val->produk;?></span>
												</div>
												<!-- End Col -->
	
												<div class="col-sm-3 mb-2 mb-sm-0">
													<span class="texat-secondary small"><?= $val->tanggal;?></span>
												</div>
												<!-- End Col -->

												<div class="col-sm-1 mb-2 mb-sm-0">
													<a href="<?= site_url('transaksi/detail/'.$val->id);?>" target="_blank" class="btn btn-white btn-xs"><i class="bi bi-box-arrow-up-right"></i></a>
												</div>
												<!-- End Col -->
											</div>
											<!-- End Row -->
										</li>
									<?php endforeach; ?>
									<?php else:?>
										<li class="list-group-item p-3">
											<div class="row">
												<div class="col text-center">
													<span class="h6">Belum ada transaksi</span>
												</div>
												<!-- End Col -->
											</div>
											<!-- End Row -->
										</li>
									<?php endif;?>
								</div>
							</ul>
						</div>

						<div id="aksesLog" class="" style="display: none; min-height: 15rem;">
							<!-- List Striped -->
							<ul class="list-group list-group-lg">
								<li class="list-group-item p-2 active">
									<span style="margin-top: -20px; margin-left: 5px" class="fw-bold">Akses log
										member</span>
								</li>
							</ul>
						</div>
					</div>
					<!-- End Content Step Form -->
				</div>
			</div>
			<!-- End Row -->
		</form>
		<!-- End Step Form -->
		<!-- End List Striped -->
	</div>
</div>

<script src="<?= base_url(); ?>assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script>
	// INITIALIZATION OF STEP FORM
	// =======================================================
	new HSStepForm('.js-step-form', {
		finish($el) {
			const $successMessageTempalte = $el.querySelector('.js-success-message').cloneNode(true)

			$successMessageTempalte.style.display = 'block'

			$el.style.display = 'none'
			$el.parentElement.appendChild($successMessageTempalte)
		}
	})

</script>
