<!-- Page Header -->
<div class="docs-page-header">
    <div class="row align-items-center">
        <div class="col-sm">
            <h1 class="docs-page-header-title">Referral</h1>
            </h1>
            <p class="docs-page-header-text">Manage Referral of your website</p>
        </div>
    </div>
</div>
<!-- End Page Header -->

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="<?= site_url('api/website/ubahReferral'); ?>" method="post" class="js-validate needs-validation" novalidate enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="inputWebsiteTitle" class="form-label">Referral Title <small class="text-danger">*</small></label>
                                <input type="text" id="inputWebsiteTitle" class="form-control form-control-sm" name="referral_title" value="<?= $referral_title; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="inputWebsiteTitle" class="form-label">Referral Interest <small class="text-danger">*</small></label>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="inputWebsiteTitle" class="form-label fw-normal">Transaksi <small class="text-danger">*</small></label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputMailerMode">Rp</span>
                                            <input type="number" id="inputWebsiteTitle" class="form-control form-control-sm" name="interest_transaksi" value="<?= isset($referral_interest['interest_transaksi']) ? $referral_interest['interest_transaksi'] : 0; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="inputWebsiteTitle" class="form-label fw-normal">Cashback <small class="text-danger">*</small></label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputMailerMode">Rp</span>
                                            <input type="number" id="inputWebsiteTitle" class="form-control form-control-sm" name="interest_cashback" value="<?= isset($referral_interest['interest_cashback']) ? $referral_interest['interest_cashback'] : 0; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="inputWebsiteTitle" class="form-label fw-normal">Minimal Transaksi <small class="text-danger">*</small></label>
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputMailerMode">Rp</span>
                                            <input type="number" id="inputWebsiteTitle" class="form-control form-control-sm" name="interest_minimal" value="<?= isset($referral_interest['interest_minimal']) ? $referral_interest['interest_minimal'] : 0; ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="inputWebDesc">Referral Description <small class="text-danger">*</small></label>
                                <textarea type="text" id="inputWebDesc" class="form-control editor" rows="4" name="referral_description" placeholder="Referral Description" required><?= $referral_description; ?></textarea>
                                <small class="text-secondary">This is use on metatag as well</small>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <figure class="w-25">
                                    <img src="<?= base_url(); ?><?= $referral_image; ?>" id="metodeTambah-preview" class="img-thumbnail img-fluid" alt="Thumbnail image" onerror="this.onerror=null;this.src='<?= base_url(); ?><?= 'assets/images/placeholder.jpg' ?>';">
                                </figure>
                                <label for="metodeTambah-upload" class="form-label">Image <small class="text-muted">(optional)</small>:</label>
                                <div class="input-group">
                                    <input type="file" class="form-control form-control-sm imgprev" name="image" accept="image/*, .svg" id="metodeTambah-upload">
                                </div>
                                <small class="text-muted">Max file size 1Mb</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="inputWebsitePenggunaan">Penggunaan <small class="text-danger">*</small></label>
                                <textarea type="text" id="inputWebsitePenggunaan" class="form-control editor" rows="3" name="penggunaan_referral" placeholder="Penggunaan" required><?= $penggunaan_referral; ?></textarea>
                            </div>
                        </div>
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