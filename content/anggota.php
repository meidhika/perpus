<?php
$queryAnggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
// hanya mengambil nama level saja dari tabel level, dan ambil id_level yg sesuai dengan id di tabel level

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>DATA ANGGOTA</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="?pg=tambah-anggota" class="btn btn-primary">Tambah</a>
                    </div>
                    <?php if (isset($_GET['tambah'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Data Berhasil Ditambah,</strong> data yang anda masukkan berhasil ditambahkan.
                            <a href="index.php?pg=anggota" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['ubah'])) : ?>
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Data Berhasil Dirubah,</strong> data yang anda masukkan berhasil dirubah.
                            <a href="index.php?pg=anggota" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['hapus'])) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Data Berhasil Dihapus,</strong> data telah dihapus permanen.
                            <a href="index.php?pg=anggota" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
                        </div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Lengkap</th>
                                <th>NISN</th>
                                <th>Jenis Kelamin</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowAnggota = mysqli_fetch_assoc($queryAnggota)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $rowAnggota['nama_lengkap'] ?></td>
                                    <td><?= $rowAnggota['nisn'] ?></td>
                                    <td><?= $rowAnggota['jenis_kelamin'] ?></td>
                                    <td><?= $rowAnggota['no_telp'] ?></td>
                                    <td><?= $rowAnggota['alamat'] ?></td>
                                    <td><a href="?pg=tambah-anggota&edit=<?= $rowAnggota['id'] ?>" class="btn btn-sm btn-primary">Edit</a> |

                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?pg=tambah-anggota&delete=<?= $rowAnggota['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
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