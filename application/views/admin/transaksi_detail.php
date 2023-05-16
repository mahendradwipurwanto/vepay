<div class="row justify-content-center mt-5">
	<div class="col-8">
		<!-- Accordion -->
		<div class="accordion" id="accordionExample">
			<div class="accordion-item">
				<div class="accordion-header mb-2" id="headingOne">
					<a class="accordion-button bg-primary text-white" role="button" data-bs-toggle="collapse"
						data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Detail Transaksi #<?= $transaksi->kode;?>
					</a>
				</div>
				<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
					data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<!-- List Striped -->
						<ul class="list-group list-group-lg">
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">ID Transaksi</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->id;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Kode Transaksi</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span>#<?= $transaksi->kode;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Status Transaksi</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<?php if($transaksi->status == 1):?>
										<span class="badge bg-secondary">Pending</span>
										<?php elseif($transaksi->status == 2):?>
										<span class="badge bg-success">Success</span>
										<?php elseif($transaksi->status == 3):?>
										<span class="badge bg-danger">Rejected</span>
										<?php elseif($transaksi->status == 4):?>
										<span class="badge bg-warning">Expired</span>
										<?php endif;?>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Tanggal Pembelian</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= date("d F Y - H:i", $transaksi->created_at);?> WIB</span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Member/Pelanggan</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->name;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>

							<!-- PRODUCT -->

							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Produk</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->product;?> - <?= $transaksi->product;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Metode Pembayaran</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->metode;?></span>
										<img src="<?= base_url();?><?= $transaksi->img_metode;?>"
											alt="<?= $transaksi->metode;?>"
											onerror="this.onerror=null;this.src='<?= base_url();?><?= 'assets/images/placeholder.jpg'?>';"
											style="width: 65px; margin-left: 5px;">
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<?php if(!is_null($transaksi->no_rek)):?>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">No rekening/ No Ewallet</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->no_rek;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<?php endif;?>
							<?php if((!isset($transaksi->m_vcc_id) && is_null($transaksi->m_vcc_id)) || $transaksi->is_vcc == 0):?>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Akun Tujuan <small class="text-secondary"><i>(email atau nomor
													wallet
													blockchain)</i></small></span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->account;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<?php endif;?>
							<?php if(isset($transaksi->no_tujuan) && !is_null($transaksi->no_tujuan)):?>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Nomor Tujuan</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->no_tujuan;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<?php endif;?>

							<!-- END PRODUCT -->

							<!-- VCC  -->
							<?php if((isset($transaksi->m_vcc_id) && !is_null($transaksi->m_vcc_id)) || $transaksi->is_vcc == 1):?>
							<?php if(isset($transaksi->vcc_number) && isset($transaksi->vcc_holder) && isset($transaksi->jenis_vcc)):?>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Nomor VCC</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->vcc_number;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Nama Pemegang</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->vcc_holder;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Jenis kartu VCC</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->jenis_vcc;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<?php else:?>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Jenis VCC</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span>Pembuatan Kartu VCC baru</span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<?php endif;?>
							<?php endif;?>
							<!-- END VCC -->


							<!-- BLOCKCHAIN -->
							<?php if(isset($transaksi->m_blockchain_id) && !is_null($transaksi->m_blockchain_id)):?>
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Blockchain</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->blockchain;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
							<?php endif;?>
							<!-- END BLOCKCHAIN -->
							<li class="list-group-item p-3">
								<div class="row">
									<div class="col-sm-4 mb-2 mb-sm-0">
										<span class="h6">Whatsapp Pelanggan</span>
									</div>
									<!-- End Col -->

									<div class="col-sm-8 mb-2 mb-sm-0">
										<span><?= $transaksi->phone;?></span>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<div class="accordion-header mb-2" id="headingTwo">
					<a class="accordion-button bg-primary text-white collapsed" role="button" data-bs-toggle="collapse"
						data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						Bukti transfer
					</a>
				</div>
				<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
					data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<!-- List Striped -->
						<ul class="list-group list-group-lg">
							<li class="list-group-item p-3">
								<div class="row d-flex justify-content-center">
									<div class="col-sm-6 mb-2 mb-sm-0">
										<figure class="text-center mb-2">
											<img id="imgthumbnail" class="img-thumbnail img-fluid w-100"
												alt="Thumbnail image"
												src="<?= base_url();?><?= isset($transaksi->bukti) ? $transaksi->bukti : 'assets/images/placeholder.jpg';?>">
										</figure>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
						</ul>
						<!-- End List Striped -->
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<div class="accordion-header mb-2" id="headingThree">
					<a class="accordion-button bg-primary text-white collapsed" role="button" data-bs-toggle="collapse"
						data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						Bukti verifikasi
					</a>
				</div>
				<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
					data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<!-- List Striped -->
						<ul class="list-group list-group-lg">
							<li class="list-group-item p-3">
								<div class="row d-flex justify-content-center">
									<div class="col-sm-6 mb-2 mb-sm-0">
										<figure class="text-center mb-2">
											<img id="imgthumbnail" class="img-thumbnail img-fluid w-100"
												alt="Thumbnail image"
												src="<?= base_url();?><?= isset($transaksi->bukti_verif) ? $transaksi->bukti_verif : 'assets/images/placeholder.jpg';?>">
										</figure>
									</div>
									<!-- End Col -->
								</div>
								<!-- End Row -->
							</li>
						</ul>
						<!-- End List Striped -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Accordion -->
	</div>
</div>
