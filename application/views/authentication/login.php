<!-- Signup Form -->
<div class="container content-space-2 content-space-lg-3">
	<div class="row justify-content-lg-center align-items-center">
		<div class="col-md-6 col-lg-5">
			<!-- Heading -->
			<div class="text-center mb-5 mb-md-7">
				<h1 class="h2">Selamat Datang</h1>
				<p>Masukkan email dan password akun anda.</p>
			</div>
			<!-- End Heading -->
			<!-- Form -->
			<form action="<?= site_url('authentication/proses_login');?>" method="post"
				class="js-validate needs-validation" novalidate>
				<!-- Card -->
				<div class="card">
					<div class="card-body">

						<?php if($this->session->userdata('act') == 'session-expired'):?>
						<div class="alert alert-primary small">
							Sesi login anda telah habis, harap login ke akun anda
						</div>
						<?php endif;?>
						<!-- Form -->
						<div class="mb-3">
							<label class="form-label" for="signupModalFormSignupEmail">Email</label>
							<div class="input-group input-group-merge">
								<div class="input-group-prepend input-group-text" id="inputGroupMergeEmail">
									<i class="bi-envelope-open"></i>
								</div>
								<input type="email" class="form-control" name="email" id="signupModalFormSignupEmail"
									placeholder="email@site.com" aria-label="email@site.com"
									aria-describedby="inputGroupMergeEmail" required>
								<span class="invalid-feedback">Please enter a valid email address.</span>
							</div>
						</div>
						<!-- End Form -->

						<!-- Form -->
						<div class="mb-3">
							<label class="form-label" for="signupModalFormSignupPassword">Password</label>

							<div class="input-group input-group-merge" data-hs-validation-validate-class>
								<div class="input-group-prepend input-group-text">
									<i class="bi-key"></i>
								</div>
								<input type="password" class="js-toggle-password form-control form-control-lg"
									minlength="8" name="password" autocomplete="off" id="signupModalFormSignupPassword"
									placeholder="8+ characters required" aria-label="8+ characters required" required
									data-hs-toggle-password-options='{
                             "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                             "defaultClass": "bi-eye-slash",
                             "showClass": "bi-eye",
                             "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                           }'>
								<a class="js-toggle-password-target-1 input-group-append input-group-text"
									href="javascript:;">
									<i class="js-toggle-passowrd-show-icon-1 bi-eye"></i>
								</a>
							</div>

							<span class="invalid-feedback">Please enter a valid password.</span>

							<a class="form-label-link d-none" href="<?= site_url('forgot-password');?>">Forgot
								password?</a>
						</div>
						<!-- End Form -->

						<div class="row align-items-center">
							<div class="col-sm-7 mb-3 mb-sm-0">
								<p class="card-text small d-none">Belum punya akun? <a class="link"
										href="<?= site_url('daftar');?>">Daftar sekarang</a></p>
							</div>
							<!-- End Col -->

							<div class="col-sm-5 text-sm-end">
								<button type="submit" class="btn btn-sm btn-primary btn-lg">Masuk</button>
							</div>
							<!-- End Col -->
						</div>
						<!-- End Row -->
					</div>
				</div>
				<!-- End Card -->
			</form>
			<!-- End Form -->
		</div>
		<!-- End Col -->
	</div>
	<!-- End Row -->
</div>
<!-- End Signup Form -->
