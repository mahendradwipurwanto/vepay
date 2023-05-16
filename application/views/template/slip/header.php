<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required Meta Tags Always Come First -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Title -->
	<title>
		<?= ($this->uri->segment(1) ? ucwords(str_replace('-', ' ', $this->uri->segment(1)) . ' ' . ($this->uri->segment(2) ? str_replace('-', ' ', $this->uri->segment(2)) : "") . " - ".$web_title) : $web_title); ?>
	</title>

	<meta name="description" content="<?= $web_desc; ?>">
	<meta property="og:title"
		content="<?= ($this->uri->segment(1) ? ucwords(str_replace('-', ' ', $this->uri->segment(1)) . ' ' . ($this->uri->segment(2) ? str_replace('-', ' ', $this->uri->segment(2)) : "") . $web_title) : $web_title); ?>">
	<meta property="og:description" content="<?= $web_desc; ?>">
	<meta property="og:image" content="<?= base_url(); ?><?= $web_icon?>">
	<meta property="og:url" content="<?= base_url(uri_string()) ?>">

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= base_url(); ?><?= $web_icon;?>">

	<!-- Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

	<!-- CSS Implementing Plugins -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugin/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/aos/dist/aos.css">

	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/swiper/swiper-bundle.min.css">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@5.0.0/minified/introjs.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/plugin/intro-js-modern.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<!-- Tagsinput -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css"
		integrity="sha512-uKwYJOyykD83YchxJbUxxbn8UcKAQBu+1hcLDRKZ9VtWfpMb1iYfJ74/UIjXQXWASwSzulZEC1SFGj+cslZh7Q=="
		crossorigin="anonymous" />
	<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">

	<!-- CSS Front Template -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/theme.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/docs.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.min.css?<?= time();?>">

	<!-- JS Global Compulsory  -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js">
	</script>
	<script type="text/javascript" src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="//cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
	<!-- sweetalert2 -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/plugin/sweetalert2/sweetalert2.min.js"></script>
	<!-- ckeditor -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/plugin/ckeditor/ckeditor.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/intro.js@5.0.0/minified/intro.min.js"></script>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<!-- Tagsinput -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js"
		integrity="sha512-wTIaZJCW/mkalkyQnuSiBodnM5SRT8tXJ3LkIUA/3vBJ01vWe5Ene7Fynicupjt4xqxZKXA97VgNBHvIf5WTvg=="
		crossorigin="anonymous"></script>
	<script src="<?= base_url();?>assets/js/apexchart.js"></script>
</head>



<body class="navbar-sidebar-aside-lg">
  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main">