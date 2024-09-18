<?php

if (isset($_POST['simpan'])) {
    // jika param edit ada maka update, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    $kode_transaksi = $_POST['kode_transaksi'];
    $id_anggota = $_POST['id_anggota'];
    $id_user = $_POST['id_user'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $id_kategori = $_POST['id_kategori'];

    $insert = mysqli_query($koneksi, "INSERT INTO peminjaman (kode_transaksi, id_anggota, id_user, tgl_pinjam, tgl_kembali, status) 
    VALUES ('$kode_transaksi','$id_anggota', '$id_user', '$tgl_pinjam', '$tgl_kembali', '1' )");
    if ($insert) {
        $id_peminjaman = mysqli_insert_id($koneksi);
        foreach ($id_kategori as $key => $value) {
            $id_kategori = $_POST['id_kategori'][$key];
            $id_buku = $_POST['id_buku'][$key];

            $insert = mysqli_query($koneksi, "INSERT INTO detail_peminjaman (id_peminjaman, id_buku, id_kategori) 
        VALUES ($id_peminjaman, $id_buku, $id_kategori)");
            header("location:?pg=peminjaman&tambah=berhasil");
        }
    }

    // header("location:?pg=user&tambah=berhasil");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "UPDATE peminjaman SET deleted_at = 1 WHERE id = '$id'");
    header("location:?pg=peminjaman&hapus=berhasil");
}

if (isset($_GET['detail'])) {
    //Data Peminjam
    $id = $_GET['detail'];
    $detail = mysqli_query($koneksi, "SELECT anggota.nama_lengkap as nama_anggota, peminjaman.*, user.nama_lengkap FROM peminjaman LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota LEFT JOIN user on user.id = peminjaman.id_user
     WHERE peminjaman.id = '$id'");
    $rowDetail = mysqli_fetch_assoc($detail);

    // menghitung durasi / lama pinjam
    $tanggal_pinjam = $rowDetail['tgl_pinjam'];
    $tanggal_kembali = $rowDetail['tgl_kembali'];

    $date_pinjam = new DateTime($tanggal_pinjam);
    $date_kembali = new DateTime($tanggal_kembali);
    $interval = $date_pinjam->diff($date_kembali);
    // echo "Durasi buku yang dipinjam selama " . $interval->days . "hari";


    //Data Buku Yang dipinjam
    $queryDetail = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman LEFT JOIN buku ON buku.id = detail_peminjaman.id_buku LEFT JOIN kategori ON kategori.id = buku.id_kategori WHERE id_peminjaman = '$id'");
}

$queryKodeTrans = mysqli_query($koneksi, "SELECT max(id) as id_transaksi FROM peminjaman");
$rowKodeTrans = mysqli_fetch_assoc($queryKodeTrans);
$no_urut = $rowKodeTrans['id_transaksi'];
$no_urut++;
$kode_transaksi = "PJ" . date("dmY") . sprintf("%03s", $no_urut);

$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");


?>
<?php
if (isset($_GET['detail'])) : ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card" style="background-color: rgba(255, 255, 255, 0.8);">
                    <div class="card-header">
                        <h3>Detail Transaksi Peminjaman</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Kode Transaksi</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo $rowDetail['kode_transaksi'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Pinjam</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo date('D, d M Y', strtotime($rowDetail['tgl_pinjam']))  ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Tanggal Kembali</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo date('D, d M Y', strtotime($rowDetail['tgl_kembali']))  ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Durasi Pinjam</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo $interval->days . " Hari" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Anggota</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo $rowDetail['nama_anggota'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Nama Petugas</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php echo $rowDetail['nama_lengkap'] ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Status</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php

                                        echo getStatus($rowDetail['status']); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Tabel -->
                            <div class="my-3">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori Buku</th>
                                        <th>Judul Buku</th>
                                    </tr>
                                    <?php
                                    $no = 1;
                                    while ($rowDetail = mysqli_fetch_assoc($queryDetail)) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $rowDetail['nama_kategori'] ?></td>
                                            <td><?= $rowDetail['judul'] ?></td>
                                        </tr>
                                    <?php endwhile ?>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <h3>Transaksi Peminjaman</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3 row">
                                <div class="col-sm-2">
                                    <label for="">Kode Transaksi</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="kode_transaksi" value="<?= ($kode_transaksi ?? '') ?>" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-2">
                                    <label for="">Nama Anggota</label>
                                </div>
                                <div class="col-sm-3">
                                    <select name="id_anggota" id="" class="form-control">
                                        <option value="">Pilih Anggota</option>
                                        <?php while ($rowAnggota = mysqli_fetch_assoc($queryAnggota)) : ?>
                                            <option value="<?= $rowAnggota['id'] ?>"><?= $rowAnggota['nama_lengkap'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Pinjam</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" name="tgl_pinjam" value="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-2">
                                    <label for="">Tanggal Kembali</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" name="tgl_kembali" value="">
                                </div>
                            </div>
                            <div class="mb-5 row">
                                <div class="col-sm-2">
                                    <label for="">Nama Petugas</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="" value="<?= ($_SESSION['NAMA_LENGKAP']) ?? '' ?>" readonly>
                                    <input type="hidden" class="form-control" name="id_user" value="<?= ($_SESSION['ID_USER']) ?? '' ?>" readonly>
                                </div>
                            </div>

                            <!-- GET  DATA Kategori Buku dan Buku -->
                            <div class="mb-3 row">
                                <div class="col-sm-2">
                                    <label for="">Kategori Buku</label>
                                </div>
                                <div class="col-sm-3">
                                    <select id="id_kategori" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($rowKategori = mysqli_fetch_assoc($queryKategori)) : ?>
                                            <option value="<?= $rowKategori['id'] ?>"><?= $rowKategori['nama_kategori'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-2">
                                    <label for="">Nama Buku</label>
                                </div>
                                <div class="col-sm-3">
                                    <select id="id_buku" class="form-control">
                                        <option value="">Pilih Buku</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="tahun_terbit">
                            <div class="my-5">
                                <div align="right" class="my-3">
                                    <button type="button" id="tambah-row" class="btn btn-outline-primary tambah-row">Tambah</button>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori Buku</th>
                                            <th>Judul Buku</th>
                                            <th>Tahun Terbit</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-3">
                                <input name="simpan" value="Simpan" type="submit" class="btn btn-primary mt-3">
                                <a href="?pg=peminjaman" class="btn btn-secondary mt-3 mx-1" id="back">Kembali</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif ?>