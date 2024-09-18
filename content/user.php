<?php
$queryUser = mysqli_query($koneksi, "SELECT level.nama_level, user.* FROM user LEFT JOIN level ON level.id = user.id_level ORDER BY id DESC");
// hanya mengambil nama level saja dari tabel level, dan ambil id_level yg sesuai dengan id di tabel level

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>DATA USER</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="?pg=tambah-user" class="btn btn-primary">Tambah</a>
                        <a class="btn btn-outline-primary mx-3" href="?pg=level">Tambah Level</a>
                    </div>
                    <?php if (isset($_GET['tambah'])) : ?>
                        <div class="alert alert-success">Data Berhasil Ditambah</div>
                    <?php endif; ?>
                    <?php if (isset($_GET['hapus'])) : ?>
                        <div class="alert alert-danger">Data Telah Dihapus</div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Level</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowUser = mysqli_fetch_assoc($queryUser)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $rowUser['nama_level'] ?></td>
                                    <td><?= $rowUser['nama_lengkap'] ?></td>
                                    <td><?= $rowUser['email'] ?></td>
                                    <td><a href="?pg=tambah-user&edit=<?= $rowUser['id'] ?>" class="btn btn-sm btn-primary">Edit</a> |

                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?pg=tambah-user&delete=<?= $rowUser['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
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