<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Dashboard</h1>
			<p class="docs-page-header-text">Pantau secara singkat informasi website anda.</p>
		</div>
	</div>
</div>
<!-- End Page Header -->
<div class="row">
	<div class="col-md-3 col-sm-12 mb-4">
		<div class="card" style="text-align: center;">
			<div class="card-body">
				<h1 class="h1"><?= number_format($count['produk'],0,",",".")?></h1>
				<div class="h6">Produk</div>
				<div style="position: absolute;right: 10px;bottom: 0px;">
					<i class="bi bi-box-seam text-primary" style="font-size: 2.5em;"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-12 mb-4">
		<div class="card" style="text-align: center;">
			<div class="card-body">
				<h1 class="h1"><?= number_format($count['member'],0,",",".")?></h1>
				<div class="h6">Member</div>
				<div style="position: absolute;right: 10px;bottom: 0px;">
					<i class="bi bi-people text-secondary" style="font-size: 2.5em;"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-12 mb-4">
		<div class="card" style="text-align: center;">
			<div class="card-body">
				<h1 class="h1"><?= number_format($count['transaksi'],0,",",".")?></h1>
				<div class="h6">Transaksi</div>
				<div style="position: absolute;right: 10px;bottom: 0px;">
					<i class="bi bi-wallet2 text-warning" style="font-size: 2.5em;"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 col-sm-12 mb-4">
		<div class="card" style="text-align: center;">
			<div class="card-body">
				<h1 class="h1">Rp. <?= number_format($count['pendapatan'],0,",",".")?></h1>
				<div class="h6">Pendapatan</div>
				<div style="position: absolute;right: 10px;bottom: 0px;">
					<i class="bi bi-cash-stack text-success" style="font-size: 2.5em;"></i>
				</div>
			</div>
		</div>
	</div>
</div>