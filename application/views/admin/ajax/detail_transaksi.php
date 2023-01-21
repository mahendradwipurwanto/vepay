<!-- List Striped -->
<ul class="list-group list-group-lg">
    <li class="list-group-item p-2 active">
        <span style="margin-top: -20px; margin-left: 5px" class="fw-bold">Detail Transaksi</span>
    </li>
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
                <span><?= $transaksi->kode;?></span>
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
                <span><?= date("d F Y", $transaksi->created_at);?></span>
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
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </li>
    <li class="list-group-item p-3">
        <div class="row">
            <div class="col-sm-4 mb-2 mb-sm-0">
                <span class="h6">Whatsapp</span>
            </div>
            <!-- End Col -->

            <div class="col-sm-8 mb-2 mb-sm-0">
                <span><?= $transaksi->phone;?></span>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </li>
    <li class="list-group-item p-2 active">
        <span style="margin-top: -20px; margin-left: 5px" class="fw-bold">Bukti transfer</span>
    </li>
    <li class="list-group-item p-3">
        <div class="row">
            <div class="col-sm-12 mb-2 mb-sm-0">
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