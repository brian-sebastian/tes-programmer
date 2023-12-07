<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <?php if ($this->session->flashdata("berhasil")) : ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <?= $this->session->flashdata("berhasil") ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        <?php endif ?>
        <?php if ($this->session->flashdata("gagal")) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <?= $this->session->flashdata("gagal") ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        <?php endif ?>
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="row">
                    <div class="col-10">
                        <h6 class="mb-4">Table Status</h6>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-solid fa-plus me-2"></i> Tambah Status</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($status as $data) : ?>
                                <tr>
                                    <th scope="row"><?= $no ?></th>
                                    <td><?= $data['nama_status'] ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm detail_button" data-bs-toggle="modal" data-bs-target="#edit" data-id="<?= $data['id_status'] ?>"><i class="fa fa-solid fa-pen me-2"></i> Edit</button>
                                        <a class="btn btn-danger btn-sm" href="<?= base_url('status/hapus/') . base64_encode($data['id_status']) ?>" onclick="return confirm('Yakin hapus status <?= $data['nama_status'] ?> ?')"><i class="fa fa-solid fa-trash me-2"></i> Delete</a>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Table End -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <form action="<?= base_url('status/tambah') ?>" method="post"> -->
            <form id="tambah">
                <div class="modal-body">
                    <div class="row">
                        <!-- Account -->

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="nama_status" class="form-label">Nama Status</label>
                                <input class="form-control" type="text" required id="nama_status" name="nama_status" placeholder="Status" autofocus />
                                <small class="text-danger pl-3" id="err_nama_status"></small>
                            </div>
                        </div>

                        <!-- /Account -->

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_tambah">Save changes</button>
                    <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit_data" method="POST">
                <input type="hidden" name="id_status" id="id_status">
                <div class="modal-body">

                    <div class="row">
                        <!-- Account -->

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="status" class="form-label">Status</label>
                                <input class="form-control" type="text" id="status_edit" name="status_edit" placeholder="status" autofocus />
                                <small class="text-danger pl-3" id="err_status_edit"></small>
                            </div>
                        </div>
                        <!-- /Account -->
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" id="simpan_ubah">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $('#btn_tambah').on('click', function() {
        const data_form = $('#tambah').serialize();

        $.ajax({
            type: "POST",
            url: "<?= base_url('status/tambah') ?>",
            dataType: "JSON",
            data: data_form,
            beforeSend: function() {

                $("#btn_tambah").prop("disabled", true)
                $("#btn_tambah").html("Tunggu...")

                $('#err_nama_status').html("")
            },
            success: function(result) {
                if (result.status == 'error') {
                    if (result.err_nama_status) {
                        $('#err_nama_status').html(result.err_nama_status);
                    }
                } else {
                    alert(result.response);
                    window.location.reload();
                }
                $("#btn_tambah").prop("disabled", false)
                $("#btn_tambah").html("Tambah")
            }
        });
    })


    $('.detail_button').on('click', function() {
        const id_status = $(this).data("id")
        $.ajax({

            url: "<?= base_url('status/tampilan_edit') ?>",
            type: "POST",
            data: {
                id_status: id_status
            },
            dataType: "JSON",
            beforeSend: function() {

                $("#simpan_ubah").prop("disabled", true)

                $('#err_status_edit').html("")

            },
            success: function(result) {

                $("#simpan_ubah").prop("disabled", false)

                if (result.status == "berhasil") {

                    const response = result.response

                    $("#id_status").val(response.id_status)
                    $("#status_edit").val(response.nama_status)

                } else {

                    alert(result.response)
                    window.location.reload()
                }

            }

        })
    })

    $('#simpan_ubah').on('click', function() {

        const data_form = $('#edit_data').serialize();

        $.ajax({
            url: '<?= base_url('status/edit') ?>',
            type: "POST",
            data: data_form,
            dataType: "JSON",
            beforeSend: function() {
                $('#err_status_edit').html("")

                $("#simpan_ubah").html("Tunggu...")
                $("#simpan_ubah").prop("disabled", true)

            },
            success: function(result) {
                if (result.status == 'error') {
                    if (result.err_status_edit) {
                        $('#err_status_edit').html(result.err_status_edit);
                    }

                } else {
                    alert(result.response);
                    window.location.reload();
                }

                $("#simpan_ubah").html("Ubah")
                $("#simpan_ubah").prop("disabled", false)
            }
        })
    })
</script>