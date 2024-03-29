    <!-- Form -->
    <div class="container-fluid login-container">
    	<div class="row">
    		<div class="col-lg-12 col-xl-12 d-flex justify-content-center align-items-center min-vh-lg-100">
    			<div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
    				<!-- Heading -->
    				<div class="text-center mb-5 mb-md-7">
    					<h1 class="h2">Forgot password?</h1>
    					<p>Enter your associate email account to continue.</p>
    				</div>
    				<!-- End Heading -->

    				<!-- Form -->
    				<form action="<?= site_url('authentication/proses_lupaPassword'); ?>" method="post"
    					class="js-validate needs-validation" novalidate>
    					<!-- Form -->
    					<div class="mb-3">
    						<div class="d-flex justify-content-between align-items-center">
    							<label class="form-label" for="signupModalFormResetPasswordEmail" tabindex="0">Email</label>

    							<a class="form-label-link" href="<?= site_url('sign-in'); ?>">
    								<i class="bi-chevron-left small ms-1"></i> Back to sign in page
    							</a>
    						</div>

    						<input type="email" class="form-control form-control-lg" name="email"
    							id="signupModalFormResetPasswordEmail" tabindex="1"
    							placeholder="Enter your email address" aria-label="Enter your email address" required>
    						<span class="invalid-feedback">Please enter a valid email.</span>
    					</div>
    					<!-- End Form -->

    					<div class="d-grid mb-3">
    						<button type="submit" class="btn btn-primary btn-lg">Send email</button>
    					</div>
    				</form>
    				<!-- End Form -->
    			</div>
    		</div>
    		<!-- End Col -->
    	</div>
    	<!-- End Row -->
    </div>
    <!-- End Form -->
