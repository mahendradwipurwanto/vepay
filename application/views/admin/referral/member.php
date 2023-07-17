<!-- Page Header -->
<div class="docs-page-header">
	<div class="row align-items-center">
		<div class="col-sm">
			<h1 class="docs-page-header-title">Member Referral
			</h1>
			<p class="docs-page-header-text">Kelola semua informasi mengenai data member referral anda.</p>
		</div>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header py-3">
				<h4 class="card-header-title">Filter data member referral</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Nama</label>
						<input type="text" id="filter_name" class="form-control form-control-sm"
							placeholder="Filter nama">
					</div>

					<div class="col-sm mb-2 mb-sm-0">
						<label for="">Nomor Whatsapp</label>
						<input type="text" id="filter_number" class="form-control form-control-sm"
							placeholder="Filter whatsapp">
					</div>
					<div class="col-sm mb-2 mb-sm-0">
						<button class="btn btn-sm btn-soft-info mt-4 me-1" type="button" id="searchBtn"
							onclick="btnSearch()"><i class="bi-search"></i>&nbsp&nbspPencarian</button>
					</div>
				</div>
			</div>
			<div class="card-header py-3">
				<h4 class="card-header-title">Data member</h4>
			</div>
			<div class="card-body">
				<!-- End Row -->
				<table id="dataTable" class="table table-borderless table-thead-bordered w-100 align-middle">
					<thead class="thead-light">
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Whatsapp</th>
							<th scope="col">Referral</th>
							<th scope="col">Saldo</th>
							<th scope="col">Bergabung</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdlMemberDetail" tabindex="-1" aria-labelledby="mdlDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mdlDeleteLabel">Detail Member</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="modalMemberContent">
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<script>
	var table = $('#dataTable').DataTable({
		'processing': true,
		'serverSide': true,
		'destroy': true,
		'searching': true,
		'scrollX': false,
		'responsive': true,
		'serverMethod': 'post',
		"columnDefs": [{
			"orderable": false,
			"targets": [0, 3, 4]
		}],
		'ajax': {
			'url': "<?= site_url('ajax/admin/getAjaxMemberReferral')?>",
			'data': function (d) {
				d.filterEmail = $('#filter_email').val()
				d.filterName = $('#filter_name').val()
				d.filterNumber = $('#filter_number').val()
			},
			'dataSrc': function (json) {
				doneLoading();
				return json.data;
			}
		},
		'columns': [{
				data: 'no'
			},
			{
				data: 'name'
			},
			{
				data: 'whatsapp'
			},
			{
				data: 'referral'
			},
			{
				data: 'saldo_referral'
			}
			,
			{
				data: 'joined_at'
			}
		]
	});

	function doneLoading() {
		$('#searchBtn').prop("disabled", false);
		// add spinner to button
		$('#searchBtn').html(
			`<i class="bi-search"></i>&nbsp&nbspSearch`
		);
	}

	function btnSearch() {
		$('#searchBtn').prop("disabled", true);
		// add spinner to button
		$('#searchBtn').html(
			`<span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span> loading...`
		);

		table.ajax.reload();
	}

</script>
