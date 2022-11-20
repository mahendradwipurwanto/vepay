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
								<span class="step-icon step-icon-soft-dark">2</span>
								<div class="step-content pb-5">
									<span class="step-title mt-2">Riwayat transaksi</span>
								</div>
							</a>
						</li>

						<li class="step-item">
							<a class="step-content-wrapper" href="javascript:;"
								data-hs-step-form-next-options='{"targetSelector": "#aksesLog"}'>
								<span class="step-icon step-icon-soft-dark stepy-last">3</span>
								<div class="step-content pb-5">
									<span class="step-title mt-2">Akses log</span>
								</div>
							</a>
						</li>
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
									<span style="margin-top: -20px; margin-left: 5px" class="fw-bold">Data pribadi</span>
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
									<span style="margin-top: -20px; margin-left: 5px" class="fw-bold">Riwayat transaksi member</span>
								</li>
							</ul>
						</div>

						<div id="aksesLog" class="" style="display: none; min-height: 15rem;">
							<!-- List Striped -->
							<ul class="list-group list-group-lg">
								<li class="list-group-item p-2 active">
									<span style="margin-top: -20px; margin-left: 5px" class="fw-bold">Akses log member</span>
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
