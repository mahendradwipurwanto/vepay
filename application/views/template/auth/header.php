<!DOCTYPE html>
<html lang="en" dir="">

<head>
	<!-- Required Meta Tags Always Come First -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Meta Website -->
	<meta name="description" content="<?= $web_desc; ?>">
	<meta property="og:title"
		content="<?= ($this->uri->segment(1) ? ucwords(str_replace('-', ' ', $this->uri->segment(1)) . ' ' . ($this->uri->segment(2) ? str_replace('-', ' ', $this->uri->segment(2)) : "") . $web_title) : $web_title); ?>">
	<meta property="og:description" content="<?= $web_desc; ?>">
	<meta property="og:image" content="<?= base_url(); ?>assets/images/<?= $web_icon?>">
	<meta property="og:url" content="<?= base_url(uri_string()) ?>">

	<title>
		<?= ($this->uri->segment(1) ? ucwords(str_replace('-', ' ', $this->uri->segment(1)) . ' ' . ($this->uri->segment(2) ? str_replace('-', ' ', $this->uri->segment(2)) : "") . " - ".$web_title) : $web_title); ?>
	</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= base_url(); ?><?= $web_icon;?>">

	<!-- Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

	<!-- CSS Implementing Plugins -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugin/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="<?= base_url();?>assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
	<link rel="stylesheet" href="<?= base_url();?>assets/vendor/aos/dist/aos.css">

	<!-- CSS Front Template -->
	<link rel="stylesheet" href="<?= base_url();?>assets/css/theme.min.css">

	<!-- stylesheet -->
	<link rel="stylesheet" href="<?= base_url();?>assets/css/custom.min.css?<?= time();?>">

	<!-- JS Global Compulsory  -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js">
	</script>
	<script type="text/javascript" src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="//cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
	<!-- sweetalert2 -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/plugin/sweetalert2/sweetalert2.min.js"></script>
	<!-- tinyMCE -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/plugin/tinymce/jquery.tinymce.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/plugin/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/plugin/tinymce-textarea.js"></script>
	<!-- ckeditor -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/plugin/ckeditor/ckeditor.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/intro.js@5.0.0/minified/intro.min.js"></script>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/plugin/jquery.inputmask.bundle.min.js"
		crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?= base_url();?>assets/js/apexchart.js"></script>
</head>

<body class="d-flex align-items-center min-h-100 bg-school">
	<!-- ========== HEADER ========== -->
	<header id="header" class="navbar navbar-expand navbar-light navbar-absolute-top">
		<div class="container-fluid">
			<nav class="navbar-nav-wrap">
				<!-- White Logo -->
				<a class="navbar-brand d-none d-lg-flex" href="<?= base_url();?>" aria-label="Front">
					<img class="navbar-brand-logo" src="<?= base_url();?><?= $web_logo_white;?>" alt="Logo">
				</a>
				<!-- End White Logo -->

				<!-- Default Logo -->
				<a class="navbar-brand d-flex d-lg-none" href="<?= base_url();?>" aria-label="Front">
					<img class="navbar-brand-logo" src="<?= base_url();?><?= $web_logo;?>" alt="Logo">
				</a>
				<!-- End Default Logo -->

				<div class="ms-auto">
					<a class="link link-sm link-secondary" href="<?= base_url();?>">
						<i class="bi-chevron-left small ms-1"></i> Go to main
					</a>
				</div>
			</nav>
		</div>
	</header>
	<!-- ========== END HEADER ========== -->

	<!-- ========== MAIN CONTENT ========== -->
	<main id="content" role="main" class="flex-grow-1" style="position: relative;">
