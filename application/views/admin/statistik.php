<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Statistik</h1>
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
				<h1 class="h1"><?= number_format($count['transaksi'],0,",",".")?> <small>(<?= number_format($count['transaksi_qty'],0,",",".")?> produk)</small></h1>
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

<div class="row">
	<div class="col-md-12 com-sm-12 mb-4">
		<div class="card card-body">
			<h4 class="card-title">Transaksi harian 30 hari terakhir (<?= $dateFilter;?>)</h4>
			<div id="chartGraphPenjualan"></div>
		</div>
	</div>
	<div class="col-md-6 com-sm-12 mb-4">
		<div class="card card-body">
			<h4 class="card-title">Top 10 Produk</h4>
			<!-- Table -->
			<table class="table table-borderless table-thead-bordered">
				<thead class="thead-light">
					<tr>
						<th scope="col" class="text-center">#</th>
						<th scope="col">Produk</th>
						<th scope="col">Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($top_product)):?>
					<?php $no = 1; foreach ($top_product as $key => $val):?>
					<tr>
						<th scope="row" class="text-center">
							<?php if($no == 1):?>
							<span class="text-warning" style="font-size: 1.5rem;">🥇</span>
							<?php elseif($no == 2):?>
							<span class="text-secondary" style="font-size: 1.5rem;">🥈</span>
							<?php elseif($no == 3):?>
							<span style="font-size: 1.5rem; color: #924b18;">🥉</span>
							<?php else:?>
							<?= $no;?>
							<?php endif;?>
						</th>
						<td><?= $val->name;?></td>
						<td><?= $val->total_sales;?> Pembelian</td>
					</tr>
					<?php $no++; endforeach;?>
					<?php else:?>
					<tr>
						<th colspan="3" class="text-center">Belum ada data</th>
					</tr>
					<?php endif;?>
				</tbody>
			</table>
			<!-- End Table -->
		</div>
	</div>
	<div class="col-md-6 com-sm-12 mb-4">
		<div class="card card-body">
			<h4 class="card-title">Top 10 Member</h4>
			<!-- Table -->
			<table class="table table-borderless table-thead-bordered">
				<thead class="thead-light">
					<tr>
						<th scope="col" class="text-center">#</th>
						<th scope="col">Member</th>
						<th scope="col">Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($top_member)):?>
					<?php $no = 1; foreach ($top_member as $key => $val):?>
					<tr>
						<th scope="row" class="text-center">
							<?php if($no == 1):?>
							<span class="text-warning" style="font-size: 1.5rem;">🥇</span>
							<?php elseif($no == 2):?>
							<span class="text-secondary" style="font-size: 1.5rem;">🥈</span>
							<?php elseif($no == 3):?>
							<span style="font-size: 1.5rem; color: #924b18;">🥉</span>
							<?php else:?>
							<?= $no;?>
							<?php endif;?>
						</th>
						<td><?= $val->name;?></td>
						<td><?= $val->total_sales;?> Pembelian</td>
					</tr>
					<?php $no++; endforeach;?>
					<?php else:?>
					<tr>
						<th colspan="3" class="text-center">Belum ada data</th>
					</tr>
					<?php endif;?>
				</tbody>
			</table>
			<!-- End Table -->
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {

		var penjualan = [ <?= implode(',', $daily_transaksi['jumlah']) ?> ];
		var tanggal = [ <?= implode(',', $daily_transaksi['created_at']) ?> ];

		var graphPenjualan = {
			series: [{
				name: 'Penjualan Harian',
				data: penjualan
			}],
			chart: {
				height: 350,
				type: 'area'
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				curve: 'straight'
			},
			xaxis: {
				type: 'datetime',
				categories: tanggal
			},
			tooltip: {
				x: {
					format: 'dd/MM/yy HH:mm'
				},
			},
		};

		var chartGraphPenjualan = new ApexCharts(document.querySelector("#chartGraphPenjualan"),
			graphPenjualan);

		chartGraphPenjualan.render();

	})

</script>
