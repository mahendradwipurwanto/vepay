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
	<div class="col-12">
		<div class="card">
			<!-- Table -->
			<div class="card-body p-4">
				<table id="dataTable" class="table table-borderless table-thead-bordered w-100 align-middle">
					<thead class="thead-light">
						<tr>
							<th width="5%">No</th>
							<th>Users</th>
							<th>Account Status</th>
							<th>Last access</th>
							<th>Device</th>
						</tr>
					</thead>

					<tbody>
					</tbody>
				</table>
			</div>
			<!-- End Table -->
		</div>
	</div>
</div>

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
			"targets": [0]
		}],
		order: [[4, 'desc']],
		'ajax': {
			'url': "<?= site_url('ajax/admin/getAjaxUserLog')?>",
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
				data: 'user'
			},
			{
				data: 'status'
			},
			{
				data: 'last_access'
			},
			{
				data: 'device'
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

</script>
