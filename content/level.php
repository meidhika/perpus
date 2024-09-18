<?php
$queryLevel = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");
?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"><h4>DATA LEVEL</h4></div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="?pg=tambah-level" class="btn btn-primary">Tambah</a>
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
                                <th>Nama Level</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowLevel = mysqli_fetch_assoc($queryLevel)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $rowLevel['nama_level'] ?></td>
                                    <td><?= $rowLevel['keterangan'] ?></td>
                                    <td><a href="?pg=tambah-level&edit=<?= $rowLevel['id']?>" class="btn btn-sm btn-primary">Edit</a> |
                                        
                                    <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?pg=tambah-level&delete=<?= $rowLevel['id']?>" class="btn btn-sm btn-danger">Delete</a></td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>