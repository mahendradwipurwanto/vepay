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
				<table
					class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTables"
					id="table">
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
						<?php if(!empty($account)):?>
						<?php $no=1;foreach($account as $key => $val):?>
						<tr>
							<td><?= $no++;?>.</td>
							<td>
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<a class="d-inline-block link-dark" href="#">
											<h6 class="text-hover-primary mb-0"><?= $val->name;?>
												<?php if($val->role == 0):?>
												<span data-bs-toggle="tooltip" data-bs-html="true" title="Super Admin"
													class="badge bg-soft-danger small ms-2">Super Admin</span>
												<?php elseif($val->role == 1):?>
												<span data-bs-toggle="tooltip" data-bs-html="true" title="Admin"
													class="badge bg-soft-info small ms-2">Admin</span>
												<?php elseif($val->role == 2):?>
												<span data-bs-toggle="tooltip" data-bs-html="true" title="Leader"
													class="badge bg-soft-warning small ms-2">Participans / Member</span>
												<?php endif;?>
											</h6>
										</a>
										<small class="d-block"><?= $val->email;?></small>
									</div>
								</div>
							</td>
							<td>
								<?php if($val->is_deleted == 1):?>
								<span data-bs-toggle="tooltip" data-bs-html="true" title="deleted"
									class="badge bg-soft-danger small ms-2">deleted</span>
								<?php elseif($val->status == 0):?>
								<span data-bs-toggle="tooltip" data-bs-html="true" title="unverified"
									class="badge bg-soft-warning small ms-2">unverified</span>
								<?php elseif($val->status == 1):?>
								<span data-bs-toggle="tooltip" data-bs-html="true" title="active"
									class="badge bg-soft-success small ms-2">active</span>
								<?php elseif($val->status == 2):?>
								<span data-bs-toggle="tooltip" data-bs-html="true" title="suspend"
									class="badge bg-secondary small ms-2">suspend</span>
								<?php endif;?>
								<?php if($val->online == 1):?>
								<span data-bs-toggle="tooltip" data-bs-html="true" title="online"
									class="badge bg-success small ms-2">online</span>
								<?php else:?>
								<span data-bs-toggle="tooltip" data-bs-html="true" title="offline"
									class="badge bg-secondary small ms-2">offline</span>
								<?php endif;?>
							</td>
							<td><?= date("d F Y - H:i:s", $val->log_time);?></td>
							<td><?= $val->device;?></td>
						</tr>
						<?php endforeach;?>
						<?php endif;?>
					</tbody>
				</table>
			</div>
			<!-- End Table -->
		</div>
	</div>
</div>
