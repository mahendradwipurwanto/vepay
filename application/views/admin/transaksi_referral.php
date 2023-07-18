<!-- Page Header -->
<div class="docs-page-header">
    <div class="row align-items-center">
        <div class="col-sm">
            <h1 class="docs-page-header-title">Transaksi Referral
            </h1>
            <p class="docs-page-header-text">Kelola semua informasi mengenai transaksi referral anda.</p>
        </div>
    </div>
</div>
<!-- End Page Header -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header py-3">
                <h4 class="card-header-title">Filter data transaksi referral</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm mb-2 mb-sm-0">
                        <label for="">Kode Transaksi</label>
                        <input type="text" id="filter_kode" class="form-control form-control-sm" placeholder="Filter kode transaksi" />
                    </div>
                    <div class="col-sm mb-2 mb-sm-0">
                        <label for="">Nama</label>
                        <input type="text" id="filter_name" class="form-control form-control-sm" placeholder="Filter nama">
                    </div>

                    <div class="col-sm mb-2 mb-sm-0">
                        <label for="">Nomor Whatsapp</label>
                        <input type="text" id="filter_number" class="form-control form-control-sm" placeholder="Filter whatsapp">
                    </div>

                    <div class="col-sm mb-2 mb-sm-0">
                        <label for="">Status</label>
                        <div class="tom-select-custom">
                            <select class="js-select form-select form-select-sm" autocomplete="off" id="filter_status" name="status" data-hs-tom-select-options='{"placeholder": "Status...", "hideSearch": true}'>
                                <option value="-1">Semua status</option>
                                <option value="0">Pending</option>
                                <option value="1">Success</option>
                                <option value="2">Reject</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm mb-2 mb-sm-0">
                        <button class="btn btn-sm btn-soft-info mt-4 me-1" type="button" id="searchBtn" onclick="btnSearch()"><i class="bi-search"></i>&nbsp&nbspPencarian</button>
                    </div>
                </div>
            </div>
            <div class="card-header py-3">
                <h4 class="card-header-title">Data transaksi referral</h4>
            </div>
            <div class="card-body">
                <!-- End Row -->
                <table id="dataTable" class="table table-borderless table-thead-bordered nowrap w-100 align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col"></th>
                            <th scope="col">Kode</th>
                            <th scope="col">Type</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nominal </th>
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
<div class="modal fade" id="mdlTransDetail" tabindex="-1" aria-labelledby="mdlDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDeleteLabel">Detail Transaksi Referral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalTransContent">
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<div id="mdlTransDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="detailUserTitle">Hapus transaksi referral</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" class="mdlDelete_id">
                <p>Apakah kamu yakin ingin menghapus transaksi referral <b class="mdlDelete_nomor">#Error</b> ini?</p>
                <div class="modal-footer px-0 pb-0">
                    <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-danger btn-sm" id="deleteBtn" onclick="deleteData()">Ya</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="mdlTransVerif" tabindex="-1" aria-labelledby="mdlDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDeleteLabel">Verifikasi Transaksi Referral</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Accordion -->
                <div class="accordion mb-3" id="accordionExample">
                    <div class="accordion-item">
                        <div class="accordion-header" id="headingOne">
                            <a class="accordion-button collapsed" role="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Transfer proof
                            </a>
                        </div>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <img src="<?= base_url(); ?>assets/images/placeholder.jpg" class="img-thumbnail w-100 mb-3" alt="" id="evidance-referral">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <figure class="text-center">
                        <img src="<?= base_url(); ?><?= 'assets/images/placeholder.jpg' ?>" id="verifikasiReferral-preview" class="img-thumbnail img-fluid" alt="Verifikasi" onerror="this.onerror=null;this.src='<?= base_url(); ?><?= 'assets/images/placeholder.jpg' ?>';">
                    </figure>
                    <label for="verifikasiReferral-upload" class="form-label">Bukti verifikasi:</label>
                    <div class="input-group">
                        <input type="file" class="form-control form-control-sm imgprev-verif" name="image" accept="image/*, .svg" id="verifikasiReferral-upload" required>
                    </div>
                    <small class="text-muted">Upload bukti verifikasi untuk pengguna. Max file size 1Mb</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <input type="hidden" name="id" class="mdlVerif_id">
                <input type="hidden" name="user_id" class="mdlVerif_userid">
                <input type="hidden" name="base64" class="mdlVerif_base64">
                <button type="button" class="btn btn-soft-success btn-sm" id="verifBtn" onclick="verifData()">Verifikasi</button>
                <button type="button" class="btn btn-soft-danger btn-sm" id="rejectBtn" onclick="rejectData()">Reject</button>
                <?php if ($this->session->userdata('role') == 0) : ?>
                    <button type="button" class="btn btn-soft-secondary btn-sm" id="pendingBtn" onclick="pendingData()">Pending</button>
                    <button type="button" class="btn btn-soft-warning btn-sm" id="cancelBtn" onclick="cancelData()">Expired</button>
                <?php endif; ?>
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
        'ordering': true,
        'searching': false,
        'scrollX': true,
        'responsive': true,
        'serverMethod': 'post',
        "columnDefs": [{
            "orderable": false,
            "targets": [0, 1]
        }],
        order: [
            [6, 'desc']
        ],
        'ajax': {
            'url': "<?= site_url('ajax/transaksi/getAjaxTransaksiReferral') ?>",
            'data': function(d) {
                d.filterEmail = $('#filter_email').val()
                d.filterName = $('#filter_name').val()
                d.filterNumber = $('#filter_number').val()
                d.filterStatus = $('#filter_status').val()
            },
            'dataSrc': function(json) {
                doneLoading();
                return json.data;
            }
        },
        'columns': [{
                data: 'no'
            },
            {
                data: 'action'
            },
            {
                data: 'kode'
            },
            {
                data: 'type'
            },
            {
                data: 'name'
            },
            {
                data: 'status'
            },
            {
                data: 'tanggal'
            },
            {
                data: 'nominal'
            }
        ]
    });

    const showMdlTransDetail = id => {
        $("#modalTransContent").html(
            `<center class="py-5"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang memuat ...</center>`
        );

        $('#mdlTransDetail').modal('show')

        jQuery.ajax({
            url: "<?= site_url('ajax/transaksi/getDetailTransReferral') ?>",
            type: 'POST',
            data: {
                transaksi_id: id
            },
            success: function(data) {
                $("#modalTransContent").html(data);
            }
        });
    }

    const showMdlTransDelete = function(id, nomor) {
        $('.mdlDelete_id').val(id);
        $('.mdlDelete_nomor').html(`#${nomor}`);
        $('#mdlTransDelete').modal('show')
    }

    const showMdlTransVerif = function(user_id, id, img) {
        $('#evidance-referral').prop('src', img);
        $('.mdlVerif_id').val(id);
        $('.mdlVerif_userid').val(user_id);
        $('#mdlTransVerif').modal('show')
    }

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

    setInterval(function() {
        table.ajax.reload();
    }, 15000);

    function verifData() {
        var id = $('.mdlVerif_id').val();
        var user_id = $('.mdlVerif_userid').val();
        var base64 = $('.mdlVerif_base64').val();

        if (base64 == '') {

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'warning',
                title: "Harap upload bukti verifikasi!"
            })
            return false;
        }

        $('#verifBtn').prop("disabled", true);
        // add spinner to button
        $('#verifBtn').html(
            `<span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span> loading...`
        );

        jQuery.ajax({
            url: "<?= site_url('api/transaksi/verificationPaymentReferral') ?>",
            type: 'POST',
            data: {
                id: id,
                user_id: user_id,
                base64: base64
            },
            success: function(data) {
                $('#verifBtn').prop("disabled", false);
                $('#verifBtn').html(`Verified`);

                $('#mdlTransVerif').modal('hide');
                $('#verifikasi-preview').attr('src', "<?= base_url(); ?><?= 'assets/images/placeholder.jpg' ?>");

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "Succesfuly verification payment"
                })

                table.ajax.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {

                table.ajax.reload();

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: thrownError
                })
            }
        });
    }

    function rejectData() {
        var id = $('.mdlVerif_id').val();
        var user_id = $('.mdlVerif_userid').val();

        $('#rejectBtn').prop("disabled", true);
        // add spinner to button
        $('#rejectBtn').html(
            `<span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span> loading...`
        );

        jQuery.ajax({
            url: "<?= site_url('api/transaksi/rejectedPaymentReferral') ?>",
            type: 'POST',
            data: {
                id: id,
                user_id: user_id
            },
            success: function(data) {
                $('#rejectBtn').prop("disabled", false);
                $('#rejectBtn').html(`Reject`);

                $('#mdlTransVerif').modal('hide');

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "Succesfuly rejected payment"
                })

                table.ajax.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {

                table.ajax.reload();

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: thrownError
                })
            }
        });
    }

    function pendingData() {
        var id = $('.mdlVerif_id').val();
        var user_id = $('.mdlVerif_userid').val();

        $('#pendingBtn').prop("disabled", true);
        // add spinner to button
        $('#pendingBtn').html(
            `<span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span> loading...`
        );

        jQuery.ajax({
            url: "<?= site_url('api/transaksi/pendingPaymentReferral') ?>",
            type: 'POST',
            data: {
                id: id,
                user_id: user_id
            },
            success: function(data) {
                $('#pendingBtn').prop("disabled", false);
                $('#pendingBtn').html(`Pending`);

                $('#mdlTransVerif').modal('hide');

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "Succesfuly set payment to pending"
                })

                table.ajax.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {

                table.ajax.reload();

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: thrownError
                })
            }
        });
    }

    function cancelData() {
        var id = $('.mdlVerif_id').val();
        var user_id = $('.mdlVerif_userid').val();

        $('#cancelBtn').prop("disabled", true);
        // add spinner to button
        $('#cancelBtn').html(
            `<span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span> loading...`
        );

        jQuery.ajax({
            url: "<?= site_url('api/transaksi/cancelPaymentReferral') ?>",
            type: 'POST',
            data: {
                id: id,
                user_id: user_id
            },
            success: function(data) {
                $('#cancelBtn').prop("disabled", false);
                $('#cancelBtn').html(`Cancel`);

                $('#mdlTransVerif').modal('hide');

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "Succesfuly set payment to cancel"
                })

                table.ajax.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {

                table.ajax.reload();

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: thrownError
                })
            }
        });
    }

    function deleteData() {
        var id = $('.mdlDelete_id').val();

        $('#deleteBtn').prop("disabled", true);
        // add spinner to button
        $('#deleteBtn').html(
            `<span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span> loading...`
        );

        jQuery.ajax({
            url: "<?= site_url('api/transaksi/deletePaymentReferral') ?>",
            type: 'POST',
            data: {
                id: id
            },
            success: function(data) {
                $('#deleteBtn').prop("disabled", false);
                $('#deleteBtn').html(`Ya`);

                $('#mdlTransDelete').modal('hide');

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: "Succesfuly delete payment data"
                })

                table.ajax.reload();
            },
            error: function(xhr, ajaxOptions, thrownError) {

                table.ajax.reload();

                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'error',
                    title: thrownError
                })
            }
        });
    }

    //binds to onchange event of your input field
    $('input.imgprev-verif').each(function() {
        console.log('#' + $(this).attr('id'));
        $('#' + $(this).attr('id')).bind('change', function() {
            console.log($(this).attr('id'));
            var parent_id = $(this).attr('id').split('-')
            //this.files[0].size gets the size of your file.
            if (this.files[0].size > (1 * 1024 * 1024)) {
                Swal.fire({
                    text: 'File size to large, maximum file size is 1 Mb !',
                    icon: 'warning',
                })
                this.value = "";
            } else {
                const [file] = this.files

                if (file) {
                    $('#' + parent_id[0] + '-preview').attr('src', URL.createObjectURL(file));
                    toBase64(file).then(
                        data => $('.mdlVerif_base64').val(data)
                    );
                }
            }
        })
    });
</script>