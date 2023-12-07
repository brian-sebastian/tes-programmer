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
                    <div class="col-9">
                        <h6 class="mb-4">Table Kategori</h6>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-solid fa-plus me-2"></i> Tambah Kategori</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($kategori as $data) : ?>
                                <tr>
                                    <th scope="row"><?= $no ?></th>
                                    <td><?= $data['nama_kategori'] ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm detail_button" data-bs-toggle="modal" data-bs-target="#edit" data-id="<?= $data['id_kategori'] ?>"><i class="fa fa-solid fa-pen me-2"></i> Edit</button>
                                        <a class="btn btn-danger btn-sm" href="<?= base_url('kategori/hapus/') . base64_encode($data['id_kategori']) ?>" onclick="return confirm('Yakin hapus kategori <?= $data['nama_kategori'] ?> ?')"><i class="fa fa-solid fa-trash me-2"></i> Delete</a>
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
            <form id="tambah">
                <div class="modal-body">
                    <div class="row">
                        <!-- Account -->

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                <input class="form-control" type="text" required id="nama_kategori" name="nama_kategori" placeholder="Kategori" autofocus />
                                <small class="text-danger pl-3" id="err_nama_kategori"></small>
                            </div>
                        </div>

                        <!-- /Account -->

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_tambah">Save changes</button>
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
                <input type="hidden" name="id_kategori" id="id_kategori">
                <div class="modal-body">

                    <div class="row">
                        <!-- Account -->

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="kategori" class="form-label">Kategori</label>
                                <input class="form-control" type="text" id="kategori_edit" name="kategori_edit" placeholder="kategori" autofocus />
                                <small class="text-danger pl-3" id="err_kategori_edit"></small>
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
            url: "<?= base_url('kategori/tambah') ?>",
            dataType: "JSON",
            data: data_form,
            beforeSend: function() {

                $("#btn_tambah").prop("disabled", true)
                $("#btn_tambah").html("Tunggu...")

                $('#err_nama_kategori').html("")
            },
            success: function(result) {
                if (result.status == 'error') {
                    if (result.err_nama_kategori) {
                        $('#err_nama_kategori').html(result.err_nama_kategori);
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
        const id_kategori = $(this).data("id")
        $.ajax({
            url: "<?= base_url('kategori/tampilan_edit') ?>",
            type: "POST",
            data: {
                id_kategori: id_kategori
            },
            dataType: "JSON",
            beforeSend: function() {

                $("#simpan_ubah").prop("disabled", true)

                $('#err_kategori_edit').html("")

            },
            success: function(result) {

                $("#simpan_ubah").prop("disabled", false)

                if (result.status == "berhasil") {

                    const response = result.response

                    $("#id_kategori").val(response.id_kategori)
                    $("#kategori_edit").val(response.nama_kategori)

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
            url: '<?= base_url('kategori/edit') ?>',
            type: "POST",
            data: data_form,
            dataType: "JSON",
            beforeSend: function() {
                $('#err_kategori_edit').html("")

                $("#simpan_ubah").html("Tunggu...")
                $("#simpan_ubah").prop("disabled", true)

            },
            success: function(result) {
                if (result.status == 'error') {
                    if (result.err_kategori_edit) {
                        $('#err_kategori_edit').html(result.err_kategori_edit);
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