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
                        <h6 class="mb-4">Table Produk</h6>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-solid fa-plus me-2"></i> Tambah Produk</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Produk</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($produk as $data) : ?>
                                <tr>
                                    <th scope="row"><?= $no ?></th>
                                    <td><?= $data['nama_produk'] ?></td>
                                    <td><?= $data['kategori_id'] ?></td>
                                    <td><?= $data['harga'] ?></td>
                                    <td><?= $data['status_id'] ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm detail_button" data-bs-toggle="modal" data-bs-target="#edit" data-id="<?= $data['id_produk'] ?>"><i class="fa fa-solid fa-pen me-2"></i> Edit</button>
                                        <a class="btn btn-danger btn-sm" href="<?= base_url('produk/hapus/') . base64_encode($data['id_produk']) ?>" onclick="return confirm('Yakin hapus produk <?= $data['nama_produk'] ?> ?')"><i class="fa fa-solid fa-trash me-2"></i> Delete</a>
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
                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                <input class="form-control" type="text" required id="nama_produk" name="nama_produk" placeholder="Nama Produk" autofocus />
                                <small class="text-danger pl-3" id="err_nama_produk"></small>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="harga" class="form-label">Harga</label>
                                <input class="form-control" onkeypress="return isNumber(event);" type="text" required id="harga" name="harga" placeholder="Harga" autofocus />
                                <small class="text-danger pl-3" id="err_harga"></small>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="kategori_id" class="form-label">Kategori</label>
                                <select class="form-select" name="kategori_id" required id="kategori_id">
                                    <option>-- Pilih --</option>
                                    <?php foreach ($kategori as $dtKategori) : ?>
                                        <option value="<?= $dtKategori['nama_kategori'] ?>"><?= $dtKategori['nama_kategori'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger pl-3" id="err_kategori_id"></small>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="status_id" class="form-label">Status</label>
                                <select class="form-select" name="status_id" required id="status_id">
                                    <option>-- Pilih --</option>
                                    <?php foreach ($status as $dtStatus) : ?>
                                        <option value="<?= $dtStatus['nama_status'] ?>"><?= $dtStatus['nama_status'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger pl-3" id="err_status_id"></small>
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
                <input type="hidden" name="id_produk" id="id_produk">
                <div class="modal-body">

                    <div class="row">
                        <!-- Account -->

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="nama_produk_edit" class="form-label">Nama Produk</label>
                                <input class="form-control" type="text" required id="nama_produk_edit" name="nama_produk_edit" placeholder="Nama Produk" autofocus />
                                <small class="text-danger pl-3" id="err_nama_produk_edit"></small>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="harga_edit" class="form-label">Harga</label>
                                <input class="form-control" onkeypress="return isNumber(event);" type="text" required id="harga_edit" name="harga_edit" placeholder="Harga" autofocus />
                                <small class="text-danger pl-3" id="err_harga_edit"></small>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="kategori_id_edit" class="form-label">Kategori</label>
                                <select class="form-select" name="kategori_id_edit" required id="kategori_id_edit">
                                    <?php foreach ($kategori as $dtKategori) : ?>
                                        <option value="<?= $dtKategori['nama_kategori'] ?>"><?= $dtKategori['nama_kategori'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger pl-3" id="err_kategori_id_edit"></small>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="status_id_edit" class="form-label">Status</label>
                                <select class="form-select" name="status_id_edit" required id="status_id_edit">
                                    <?php foreach ($status as $dtStatus) : ?>
                                        <option value="<?= $dtStatus['nama_status'] ?>"><?= $dtStatus['nama_status'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger pl-3" id="err_status_id_edit"></small>
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
    function isNumber(event) {
        var keyCode = event.which ? event.which : event.keyCode;
        if (keyCode < 48 || keyCode > 57) {
            return false; // Mencegah karakter selain angka ditampilkan
        }
    }

    $('#btn_tambah').on('click', function() {
        const data_form = $('#tambah').serialize();

        $.ajax({
            type: "POST",
            url: "<?= base_url('produk/tambah') ?>",
            dataType: "JSON",
            data: data_form,
            beforeSend: function() {

                $("#btn_tambah").prop("disabled", true)
                $("#btn_tambah").html("Tunggu...")

                $('#err_nama_produk').html("")
                $('#err_harga').html("")
                $('#err_kategori_id').html("")
                $('#err_status_id').html("")
            },
            success: function(result) {
                if (result.status == 'error') {
                    if (result.err_nama_produk) {
                        $('#err_nama_produk').html(result.err_nama_produk);
                    }
                    if (result.err_harga) {
                        $('#err_harga').html(result.err_harga);
                    }
                    if (result.err_kategori_id) {
                        $('#err_kategori_id').html(result.err_kategori_id);
                    }
                    if (result.err_status_id) {
                        $('#err_status_id').html(result.err_status_id);
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
        const id_produk = $(this).data("id")

        $.ajax({
            url: "<?= site_url("produk/tampilan_edit") ?>",
            type: "POST",
            data: {
                id_produk: id_produk
            },
            dataType: "JSON",
            beforeSend: function() {

                $("#simpan_ubah").prop("disabled", true)

                $('#err_nama_produk_edit').html("")
                $('#err_harga_edit').html("")
                $('#err_kategori_id_edit').html("")
                $('#err_status_id_edit').html("")

            },
            success: function(result) {

                $("#simpan_ubah").prop("disabled", false)

                if (result.status == "berhasil") {

                    const response = result.response

                    $("#id_produk").val(response.id_produk)
                    $("#nama_produk_edit").val(response.nama_produk)
                    $("#harga_edit").val(response.harga)
                    $("#kategori_id_edit").val(response.kategori_id)
                    $("#kategori_id_edit").trigger("change")
                    $("#status_id_edit").val(response.status_id)
                    $("#status_id_edit").trigger("change")

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
            url: '<?= base_url('produk/edit') ?>',
            type: "POST",
            data: data_form,
            dataType: "JSON",
            beforeSend: function() {
                $('#err_nama_produk_edit').html("")
                $('#err_harga_edit').html("")
                $('#err_kategori_id_edit').html("")
                $('#err_status_id_edit').html("")

                $("#simpan_ubah").html("Tunggu...")
                $("#simpan_ubah").prop("disabled", true)

            },
            success: function(result) {
                if (result.status == 'error') {
                    if (result.err_nama_produk_edit) {
                        $('#err_nama_produk_edit').html(result.err_nama_produk_edit);
                    }
                    if (result.err_harga_edit) {
                        $('#err_harga_edit').html(result.err_harga_edit);
                    }
                    if (result.err_kategori_id_edit) {
                        $('#err_kategori_id_edit').html(result.err_kategori_id_edit);
                    }
                    if (result.err_status_id_edit) {
                        $('#err_status_id_edit').html(result.err_status_id_edit);
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