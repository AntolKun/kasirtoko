<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Laporan Laba
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>

<button type="button" class="btn btn-warning" onclick="window.location=('/laporan/index')">
    Kembali
</button>

<?= $this->endSection('subjudul') ?>


<?= $this->section('isi') ?>

<div class="row">
    <div class="col-lg-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Pilih Periode</div>
            <div class="card-body bg-white">
                <p class="card-text">
                    <?= form_open('laporan/cetak-keuntungan-periode', ['target' => '_blank']) ?>
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
                    <input type="date" name="tglawal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="date" name="tglakhir" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="btnCetak" class="btn btn-block btn-success">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </button>
                    <button type="submit" name="btnExport" class="btn btn-block btn-primary">
                        <i class="fa fa-file-excel"></i> Export Excel
                    </button>
                </div>
                <?= form_close() ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Laporan Grafik</div>
            <div class="card-body bg-white">
                <div class="form-group">
                    <label for="">Pilih Periode</label>
                    <!-- <select name="periode" id="periode" class="form-control"> -->
                    <!-- <option value="daily">Daily</option> -->
                    <!-- <option value="monthly">Monthly</option> -->
                    <!-- <option value="yearly">Yearly</option> -->
                    <!-- </select> -->
                    <input type="month" class="form-control" id="bulan" value="<?= date('Y-m') ?>">
                    <!-- <button type="button" class="btn btn-sm btn-primary" id="tombolTampil">
                        Tampil
                    </button> -->
                </div>
                <div class="viewTampilGrafik">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function tampilGrafik() {
        $.ajax({
            type: "post",
            url: "/laporan/tampilGrafikBarangMasuk",
            data: {
                bulan: $('#bulan').val()
            },
            dataType: "json",
            beforeSend: function() {
                $('.viewTampilGrafik').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.viewTampilGrafik').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }

        });
    }

    function untungGrafik() {
        $.ajax({
            type: "post",
            url: "/laporan/tampilGrafikUntung",
            data: {
                bulan: $('#bulan').val()
            },
            dataType: "json",
            beforeSend: function() {
                $('.viewTampilGrafik').html('<i class="fa fa-spin fa-spinner"></i>');
                console.log($('#bulan'))
            },
            success: function(response) {
                if (response.data) {
                    $('.viewTampilGrafik').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }

        });
    }

    $(document).ready(function() {
        untungGrafik();

        $('#bulan').change(function() {
            // console.log($('#bulan').val())
            untungGrafik();
        })
    });
</script>
<?= $this->endSection('isi') ?>