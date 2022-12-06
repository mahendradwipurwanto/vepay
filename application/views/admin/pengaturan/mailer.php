<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Mailer settings</h1>
			<p class="docs-page-header-text">Manage mailer settings in here</p>
		</div>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-md-7">
		<div class="card">
			<div class="card-body">
				<form action="<?= site_url('api/website/ubahMailer');?>" method="post"
					class="js-validate needs-validation" novalidate enctype="multipart/form-data">
					<?php if($this->session->userdata('role') == 0):?>
					<div class="mb-3 justify-content-between align-items-center row">
						<div class="col-8">
							<div class="input-group input-group-sm mb-3">
								<span class="input-group-text" id="inputMailerMode">Mailer Mode <small
										class="text-danger">*</small></span>
								<input type="number" id="inputMailerMode" class="form-control form-control-sm"
									name="mailer_mode" value="<?= $mailer_mode;?>" required>
							</div>
						</div>
						<div class="col-4">
							<div class="form-check form-switch mb-1">
								<input type="checkbox" class="form-check-input" id="formMailerSmtp" name="mailer_smtp"
									<?= $mailer_smtp == 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="formMailerSmtp">Mailer SMTP</label>
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label for="inputMailerHost" class="form-label">Mailer Host<small
								class="text-danger">*</small></label>
						<input type="text" id="inputMailerHost" class="form-control form-control-sm" name="mailer_host"
							value="<?= $mailer_host;?>" required>
					</div>
					<div class="mb-3">
						<label for="inputMailerConnection" class="form-label">Mailer Connection<small
								class="text-danger">*</small></label>
						<input type="text" id="inputMailerConnection" class="form-control form-control-sm"
							name="mailer_connection" value="<?= $mailer_connection;?>" required>
					</div>
					<div class="mb-3">
						<label for="inputMailerPort" class="form-label">Mailer Port<small
								class="text-danger">*</small></label>
						<input type="text" id="inputMailerPort" class="form-control form-control-sm" name="mailer_port"
							value="<?= $mailer_port;?>" required>
					</div>
					<?php endif;?>
					<div class="mb-3">
						<label for="inputMailerAlias" class="form-label">Mailer Alias<small
								class="text-danger">*</small></label>
						<input type="text" id="inputMailerAlias" class="form-control form-control-sm"
							name="mailer_alias" value="<?= $mailer_alias;?>" required>
					</div>
					<div class="mb-3">
						<label for="inputMailerUsername" class="form-label">Mailer Username<small
								class="text-danger">*</small></label>
						<input type="mail" id="inputMailerUsername" class="form-control form-control-sm"
							name="mailer_username" value="<?= $mailer_username;?>" required>
					</div>
					<div class="mb-3">
						<label for="inputMailerPassword" class="form-label">Mailer Password<small
								class="text-danger">*</small></label>
						<input type="password" id="inputMailerPassword" class="form-control form-control-sm"
							name="mailer_password" placeholder="Password Mailer">
					</div>
					<div class="card-footer px-0">
						<button type="submit" class="btn btn-primary btn-sm float-end">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="card card-body">
			<h4>Testing config mailer</h4>
			<form action="<?= site_url('api/master/testMailer');?>" method="post" class="js-validate needs-validation"
				novalidate>
				<div class="mb-3">
					<label for="inputEmailTestingMailer">Testing email </label>
					<input type="mail" class="form-control form-control-sm" name="email" placeholder="Input Email"
						required>
				</div>
				<button type="submit" class="btn btn-primary btn-sm float-end">Test Config</button>
			</form>
			<div class="code-toolbar mt-3">
				<pre class="language-markup w-100 p-2"><?= $this->session->userdata('mailer_debug') !== null ? $this->session->userdata('mailer_debug') : 'Send test mail first';?></pre>
			</div>
		</div>
	</div>
</div>


<script>
	//  ckeditor
	$('textarea.editor').each(function () {

		CKEDITOR.replace($(this).attr('id'));

	});

</script>
