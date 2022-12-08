<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Data Transaksi Barang Keluar
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>

<button type="button" class="btn btn-sm btn-primary" onclick="location.href=('/barangkeluar/input')">
    <i class="fa fa-plus-circle"></i> Input Transaksi
</button>

<?= $this->endSection('subjudul') ?>


<?= $this->section('isi') ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- DataTables  & Plugins -->
<script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="row">
    <div class="col">
        <label>Filter Data</label>
    </div>
    <div class="col">
        <input type="date" name="tglawal" id="tglawal" class="form-control">
    </div>
    <div class="col">
        <input type="date" name="tglakhir" id="tglakhir" class="form-control">
    </div>
    <div class="col">
        <button type="button" class="btn btn-block btn-primary" id="tombolTampil">
            Tampilkan
        </button>
    </div>
</div>
<br>
<table style="width: 100%;" id="databarangkeluar" class="table table-bordered table-hover dataTable dtr-inline collapsed">
    <thead>
        <tr>
            <th>No</th>
            <th>Faktur</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Payment<br>Method</th>
            <th>Status</th>
            <th>Total Harga (Rp)</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script>
    let csrfToken = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';

    function cektransaksi(faktur) {
        window.location.href = '/barangkeluar/cektransaksi/' + faktur;
    }

    function listDataBarangKeluar() {
        var table = $('#databarangkeluar').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/barangkeluar/listData",
                "type": "POST",
                "data": {
                    [csrfToken]: csrfHash,
                    tglawal: $('#tglawal').val(),
                    tglakhir: $('#tglakhir').val(),
                }
            },
            "columnDefs": [{
                "targets": [0, 5],
                "orderable": false,
            }, ],
        });

    }
    $(document).ready(function() {
        listDataBarangKeluar();

        $('#tombolTampil').click(function(e) {
            e.preventDefault();
            listDataBarangKeluar();
        });
    });

    function cetak(faktur) {
        let windowCetak = window.open('/barangkeluar/cetakfaktur/' + faktur,
            "Cetak Faktur Barang Keluar",
            "width=200,height=400");

        windowCetak.focus();
    }

    function hapus(faktur) {
        Swal.fire({
            title: 'Hapus Transaksi',
            text: "Yakin dihapus ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangkeluar/hapusTransaksi",
                    data: {
                        [csrfToken]: csrfHash,
                        faktur: faktur
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            listDataBarangKeluar();
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })
    }

    function edit(faktur) {
        window.location.href = ('/barangkeluar/edit/') + faktur;
    }
</script>

<?= $this->endSection('isi') ?>