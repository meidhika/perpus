<?php
$queryPengembalian = mysqli_query($koneksi, "SELECT pengembalian.*, peminjaman.status, anggota.nama_lengkap as nama_anggota, user.nama_lengkap
FROM pengembalian
INNER JOIN peminjaman ON peminjaman.id = pengembalian.id_peminjaman
INNER JOIN anggota ON anggota.id = peminjaman.id_anggota
INNER JOIN user ON user.id = peminjaman.id_user
ORDER BY pengembalian.id DESC");


?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Transaksi Pengembalian</div>
                <div class="card-body">
                    <div align="right" class="mb-3">
                        <a href="?pg=tambah-pengembalian" class="btn btn-primary">Tambah</a>
                    </div>
                    <?php if (isset($_GET['tambah'])) : ?>
                        <div class="alert alert-success">Data Berhasil Ditambah</div>
                    <?php endif; ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pengembalian</th>
                                <th>Nama Anggota</th>
                                <th>Nama Petugas</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Status</th>
                                
                                <th>Denda</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowPengembalian = mysqli_fetch_assoc($queryPengembalian)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $rowPengembalian['kode_pengembalian'] ?></td>
                                    <td><?= $rowPengembalian['nama_anggota'] ?></td>
                                    <td><?= $rowPengembalian['nama_lengkap'] ?></td>
                                    <td><?= $rowPengembalian['tgl_pengembalian'] ?></td>
                                    <td> <?= getStatus($rowPengembalian['status']) ?></td>
                                    

                                    <td><?= $rowPengembalian['denda'] ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-warning"
                                            href="?pg=tambah-pengembalian&detail=<?= $rowPengembalian['id'] ?>">Detail</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>