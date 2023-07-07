<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Credentials</h1>
			<p class="docs-page-header-text">Manage all credentials account in here</p>
		</div>
	</div>
</div>
<!-- Card -->
<div class="row">
	<div class="col-4">
		<div class="card card-body">
			<h4>Master Credentials</h4>
			<form action="<?= site_url('api/website/ubahPasswordMaster');?>" method="post"
				class="js-validate needs-validation" novalidate>
				<div class="mb-3">
					<label for="inputEmailAdmin">Email Admin</label>
					<input type="mail" class="form-control form-control-sm" name="email" placeholder="Input Email"
						value="<?= $admin->email;?>" required>
				</div>
				<div class="mb-3">
					<label for="inputPasswordAdmin">Password Admin (LAMA)</label>
					<input type="password" class="form-control form-control-sm" name="lama" value="">
				</div>
				<div class="mb-3">
					<label for="inputPasswordAdmin">Password Admin (BARU)</label>
					<input type="password" class="form-control form-control-sm" name="admin" value="">
				</div>
				<?php if($this->session->userdata('role') == 0):?>
				<div class="mb-3">
					<label for="inputPasswordMaster">Password Master</label>
					<input type="password" class="form-control form-control-sm" name="master" value="" required>
				</div>
				<?php endif; ?>
				<button type="submit" class="btn btn-primary btn-sm float-end">Save changes</button>
			</form>
		</div>
	</div>
</div>
<!-- End Card -->
