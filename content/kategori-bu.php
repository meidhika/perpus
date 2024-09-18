<?php
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>DATA KATEGORI</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="?pg=tambah-kategori" class="btn btn-primary">Tambah</a>
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
                                <th>Nama Kategori</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowKategori = mysqli_fetch_assoc($queryKategori)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $rowKategori['nama_kategori'] ?></td>
                                    <td><?= $rowKategori['keterangan'] ?></td>
                                    <td><a href="?pg=tambah-kategori&edit=<?= $rowKategori['id'] ?>" class="btn btn-sm btn-primary">Edit</a> |

                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?pg=tambah-kategori&delete=<?= $rowKategori['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
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