<!-- Page Header -->
<div class="docs-page-header">
    <div class="row align-items-center">
        <div class="col-sm">
            <h1 class="docs-page-header-title">REFERRAL</h1>
            </h1>
            <p class="docs-page-header-text">Manage REFERRAL of your website</p>
        </div>
    </div>
</div>
<!-- End Page Header -->

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('api/website/ubahReferral'); ?>" method="post" class="js-validate needs-validation" novalidate enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="inputWebsiteTitle" class="form-label">REFERRAL Title <small class="text-danger">*</small></label>
                        <input type="text" id="inputWebsiteTitle" class="form-control form-control-sm" name="referral_title" value="<?= $referral_title; ?>" required>
                    </div>
                    <div class="mb-3">
                        <figure class="w-25">
                            <img src="<?= base_url(); ?><?= $referral_image; ?>" id="metodeTambah-preview" class="img-thumbnail img-fluid" alt="Thumbnail image" onerror="this.onerror=null;this.src='<?= base_url(); ?><?= 'assets/images/placeholder.jpg' ?>';">
                        </figure>
                        <label for="metodeTambah-upload" class="form-label">Gambar intro <small class="text-muted">(optional)</small>:</label>
                        <div class="input-group">
                            <input type="file" class="form-control form-control-sm imgprev" name="image" accept="image/*, .svg" id="metodeTambah-upload">
                        </div>
                        <small class="text-muted">Max file size 1Mb</small>
                    </div>
                    <div class="mb-3">
                        <label for="inputWebsiteTitle" class="form-label">REFERRAL Interest <small class="text-danger">*</small></label>
                        <div class="alert bg-soft-primary">
                            <p class="my-0">REFERRAL interest, adalah pengaturan komponen rumus perhitungan cashback yang didapat oleh pengguna yang memiliki referral, saat teman mereka melakukan transaksi dan transaksi tersebut berhasil diverifikasi oleh admin.</p>
                            <br>
                            <p class="my-0 fw-bolder">Rumus: <span class="fw-bold"><span class="text-success">quantity pembelian</span> * <span class="text-success">nominal cashback</span></span></p>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="inputWebsiteTitle" class="form-label fw-normal">Quantity Transaksi <small class="text-danger">*</small></label>
                                <div class="input-group input-group-sm mb-3">
                                    <input type="number" id="inputWebsiteTitle" class="form-control form-control-sm" name="interest_quantity" value="<?= isset($referral_interest['interest_quantity']) ? $referral_interest['interest_quantity'] : 0; ?>" required>
                                    <span class="input-group-text" id="inputMailerMode">quantity</span>
                                </div>
                                <small class="text-secondary">Jumlah tiap quantity yang akan dikalikan ke cashback</small>
                            </div>
                            <div class="col-6">
                                <label for="inputWebsiteTitle" class="form-label fw-normal">Nominal Cashback <small class="text-danger">*</small></label>
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" id="inputMailerMode">Rp</span>
                                    <input type="number" id="inputWebsiteTitle" class="form-control form-control-sm" name="interest_cashback" value="<?= isset($referral_interest['interest_cashback']) ? $referral_interest['interest_cashback'] : 0; ?>" required>
                                </div>
                                <small class="text-secondary">Jumlah cashback yang didapat pada setiap nominal transaksi yang diatur</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="inputWebsiteTitle" class="form-label fw-normal">Minimal Total Transaksi <small class="text-danger">*</small></label>
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" id="inputMailerMode">Rp</span>
                                    <input type="number" id="inputWebsiteTitle" class="form-control form-control-sm" name="interest_minimal" value="<?= isset($referral_interest['interest_minimal']) ? $referral_interest['interest_minimal'] : 0; ?>" required>
                                </div>
                                <small class="text-secondary">Jumlah minimal transaksi agar mendapatkan cashback (0 untuk selalu mendapatkan cashback)</small>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-normal" for="inputWebDesc">Minimal penarikan saldo REFERRAL <small class="text-danger">*</small></label>  
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" id="inputMailerMode">Rp</span>
                                    <input type="number" id="inputWebsiteTitle" class="form-control form-control-sm" name="referral_withdraw_minimum" value="<?= isset($referral_withdraw_minimum) ? $referral_withdraw_minimum : 0; ?>" required>
                                </div>
                                <small class="text-secondary">Jumlah minimal saldo referral yang dapat dicairkan</small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputWebsitePenggunaan">Penggunaan <small class="text-danger">*</small></label>
                        <textarea type="text" id="inputWebsitePenggunaan" class="form-control editor" rows="3" name="penggunaan_referral" placeholder="Penggunaan" required><?= $penggunaan_referral; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputWebDesc">REFERRAL Description <small class="text-danger">*</small></label>
                        <textarea type="text" id="inputWebDesc" class="form-control editor" rows="4" name="referral_description" placeholder="REFERRAL Description" required><?= $referral_description; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputWebDesc">REFERRAL Description Intro <small class="text-danger">*</small></label>
                        <textarea type="text" id="inputWebDescReferral" class="form-control editor" rows="4" name="desc_referral_intro" placeholder="REFERRAL Description" required><?= $desc_referral_intro; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="inputWebDesc">REFERRAL Description Info <small class="text-danger">*</small></label>
                        <textarea type="text" id="inputWebDescReferralInfo" class="form-control editor" rows="4" name="referral_desc_info" placeholder="REFERRAL Description" required><?= $referral_desc_info; ?></textarea>
                    </div>
                    <div class="card-footer px-0">
                        <button type="submit" class="btn btn-primary btn-sm float-end">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    //  ckeditor
    $('textarea.editor').each(function() {
        CKEDITOR.replace($(this).attr('id'), {
            toolbar: [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-',
                        'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight',
                        'JustifyBlock'
                    ]
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Smiley', 'SpecialChar', 'Iframe']
                },
                {
                    name: 'styles',
                    items: ['Styles', 'Format', 'Font', 'FontSize']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                }
            ]
        });

    });
</script>