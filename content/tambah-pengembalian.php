<?php

if (isset($_POST['simpan'])) {
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    //Kode Pengembalian
    $id_peminjaman = $_POST['id_peminjaman'];
    $denda = $_POST['denda'];
    $tgl_pengembalian = $_POST['tgl_pengembalian'];
    $terlambat = $_POST['terlambat'];

    $queryKodeTrans = mysqli_query($koneksi, "SELECT max(id) as id_peminjaman FROM pengembalian");
    $rowKodeTrans = mysqli_fetch_assoc($queryKodeTrans);
    $no_Urut = $rowKodeTrans['id_peminjaman'];
    $no_Urut++;

    $kode_pengembalian = "KMBLI" . date("dmY") . sprintf("%03s", $no_Urut);

    $queryInsert = mysqli_query($koneksi, "INSERT INTO pengembalian (id_peminjaman, kode_pengembalian, denda, tgl_pengembalian, terlambat) VALUES ('$id_peminjaman', '$kode_pengembalian', '$denda', '$tgl_pengembalian', '$terlambat') ");
    if ($queryInsert) {
        $updateStatus = mysqli_query($koneksi, "UPDATE peminjaman SET status = 2 WHERE id = $id_peminjaman");
        header("Location:?pg=pengembalian&tambah=berhasil");
    }
}

if (isset($_GET['detail'])) {

    //Data Pengembalian
    $id = $_GET['detail'];
    $detail = mysqli_query($koneksi, "SELECT pengembalian.*, peminjaman.*, anggota.nama_lengkap as nama_anggota, user.nama_lengkap
    FROM pengembalian
    INNER JOIN peminjaman ON peminjaman.id = pengembalian.id_peminjaman
    INNER JOIN anggota ON anggota.id = peminjaman.id_anggota
    INNER JOIN user ON user.id = peminjaman.id_user
    WHERE pengembalian.id = '$id'");
    $rowDetail = mysqli_fetch_assoc($detail);

    //ambil id_pemijaman di table pengembalian
    $get_idpeminjaman = mysqli_query($koneksi, "SELECT id_peminjaman FROM pengembalian WHERE id = '$id'");
    $idpeminjaman = mysqli_fetch_assoc($get_idpeminjaman);
    $id_peminjaman = $idpeminjaman['id_peminjaman'];


    //Data buku yang di pinjam
    $queryDetail = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman LEFT JOIN buku ON buku.id = detail_peminjaman.id_buku LEFT JOIN kategori ON kategori.id = buku.id_kategori WHERE id_peminjaman = '$id_peminjaman'");
}



$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
$queryPeminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE status = 1 ORDER BY id DESC");


?>

<?php if (isset($_GET['detail'])): ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">Detail Transaksi Pengembalian</div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Kode Pengembalian</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $rowDetail['kode_pengembalian'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Pinjam</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= date("D, d M Y", strtotime($rowDetail['tgl_pinjam'])) ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Kembali</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= date("D, d M Y", strtotime($rowDetail['tgl_kembali'])) ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Pengembalian Buku</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= date("D, d M Y", strtotime($rowDetail['tgl_pengembalian'])) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Anggota</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $rowDetail['nama_anggota'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Petugas</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $rowDetail['nama_lengkap'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Status</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= getKeterlambatan($rowDetail['terlambat']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- tabell -->
                        <div class="mb-5 mt-5">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Buku</th>
                                    <th>Judul Buku</th>
                                </tr>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($queryDetail)):
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['nama_kategori'] ?></td>
                                        <td><?= $row['judul'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="col-sm-8">

                <div class="card">
                    <div class="card-header">Data Pengembalian</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <label for="">Tanggal Kembali<span style="color:red;">*</span></label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="tgl_pengembalian" name="tgl_pengembalian"
                                        value="" required oninput="toggleTransactionCode()">
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-sm-3">
                                    <label for="">Petugas</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name=""
                                        value="<?= isset($_SESSION['NAMA_LENGKAP']) ? $_SESSION['NAMA_LENGKAP'] : '' ?>"
                                        readonly>
                                    <input type="hidden" class="form-control" name="id_user"
                                        value="<?= ($_SESSION['ID_USER'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="row mt-5 mb-5">
                                <div class="col-sm-2">
                                    <label for="">Kode Peminjaman</label>
                                </div>
                                <div class="col-sm-3">
                                    <select name="id_peminjaman" id="kode_peminjaman" class="form-control" disabled>
                                        <option value="">Pilih Kode Peminjaman</option>
                                        <?php while ($rowPeminjaman = mysqli_fetch_assoc($queryPeminjaman)) : ?>
                                            <option value="<?= $rowPeminjaman['id'] ?>"><?= $rowPeminjaman['kode_transaksi'] ?>
                                            </option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <div class="row mb-3">
                                            <div class="col-sm-4">
                                                <label for="">Nama Anggota</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input placeholder="Nama Anggota" type="text" readonly id="nama_anggota"
                                                    value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4">
                                                <label for="">Tanggal Pinjam</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input placeholder="Tanggal Pinjam" type="text" readonly id="tgl_pinjam"
                                                    value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4">
                                                <label for="">Tanggal Kembali</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input placeholder="Tanggal Kembali" type="text" readonly id="tgl_kembali"
                                                    value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4">
                                                <label for="">Terlambat</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <input placeholder="Keterlamabatan" type="text" readonly id="terlambat"
                                                    name="terlambat" value="" class="form-control">
                                                <input type="hidden" id="denda" name="denda">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 mb-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Buku</th>
                                            <th>Judul Buku</th>
                                            <th>Tahun Terbit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Pake AJAX -->
                                    </tbody>
                                </table>
                                <div align="right" class="total-denda">

                                </div>

                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>