<!-- Page Header -->
<div class="docs-page-header">
    <div class="row align-items-center">
        <div class="col-sm">
            <h1 class="docs-page-header-title">Penggunaan Promo - <?= $promo->nama; ?>
                <a href="<?= site_url('master/promo');?>" class="btn btn-soft-primary btn-sm float-end">Kembali</a>
            </h1>
            <p class="docs-page-header-text">Cek riwayat penggunaan promo oleh pengguna</p>
        </div>
    </div>
</div>
<!-- End Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-borderless table-thead-bordered nowrap w-100 align-middle dataTables" id="table">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th>Tanggal</th>
                            <th>Promo</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($promo->penggunaan)) : ?>
                            <?php $no = 1;
                            foreach ($promo->penggunaan as $val) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $val->tanggal_transaksi; ?></td>
                                    <td><?= $promo->nama; ?></td>
                                    <td><?= $val->nama_pengguna == "" ? '<span class="badge bg-soft-warning">belum mengatur nama</span>' : $val->nama_pengguna; ?></td>
                                    <td><?= $val->email; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>