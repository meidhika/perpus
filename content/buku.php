<?php
$queryBuku = mysqli_query($koneksi, "SELECT kategori.nama_kategori, buku.* FROM buku LEFT JOIN kategori ON kategori.id = buku.id_kategori ORDER BY id DESC");
// hanya mengambil nama kategori saja dari tabel kategori, dan ambil id_kategori yg sesuai dengan id di tabel kategori

?>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>DATA BUKU</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="?pg=tambah-buku" class="btn btn-primary">Tambah</a>
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
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Jumlah</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Penulis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowBuku = mysqli_fetch_assoc($queryBuku)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $rowBuku['nama_kategori'] ?></td>
                                    <td><?= $rowBuku['judul'] ?></td>
                                    <td><?= $rowBuku['jumlah'] ?></td>
                                    <td><?= $rowBuku['penerbit'] ?></td>
                                    <td><?= $rowBuku['tahun_terbit'] ?></td>
                                    <td><?= $rowBuku['penulis'] ?></td>
                                    <td><a href="?pg=tambah-buku&edit=<?= $rowBuku['id'] ?>" class="btn btn-sm btn-primary">Edit</a> |

                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?pg=tambah-buku&delete=<?= $rowBuku['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
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