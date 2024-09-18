<?php
if (isset($_POST['simpan'])) {
    // jika param edit ada maka update, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit'] : '';

    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $id_level = $_POST['id_level'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO user (nama_lengkap, email, password, id_level) VALUES ('$nama_lengkap','$email', '$password', $id_level )");
        header("location:?pg=user&tambah=berhasil");
    } else {
        $update = mysqli_query($koneksi, "UPDATE user SET nama_lengkap = '$nama_lengkap', email = '$email', id_level = '$id_level', password = '$password' WHERE id = '$id'");
        header("location:?pg=user&ubah=berhasil");
    }

    // header("location:?pg=user&tambah=berhasil");
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$id'");
    header("location:?pg=user&hapus=berhasil");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

$level = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");


?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card">
                <div class="card-header">Data User</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="pilihlevel" class="form-label"></label>
                            <select name="id_level" id="pilihlevel" class="form-control">
                                <option value="">Pilih Level</option>
                                <?php while ($rowLevel = mysqli_fetch_assoc($level)) : ?>
                                    <!-- mengambil data id dan nama_level dari tabel level -->
                                    <option <?php echo isset($rowEdit['id_level']) ? ($rowEdit['id_level'] == $rowLevel['id']) ? 'selected' : '' : '' ?> value="<?= $rowLevel['id'] ?>"><?= $rowLevel['nama_level'] ?>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input value="<?= $rowEdit['nama_lengkap'] ?? ''; ?>" type="text" class="form-control" id="" name="nama_lengkap">

                            <label for="" class="form-label">Email</label>
                            <input value="<?= $rowEdit['email'] ?? ''; ?>" type="email" class="form-control" id="" name="email">

                            <label for="" class="form-label">Password</label>
                            <input type="password" class="form-control" id="" name="password">

                            <input name="simpan" value="Simpan" type="submit" class="btn btn-primary mt-3">
                            <a href="?pg=user" class="btn btn-danger mt-3 mx-1" id="back">Kembali</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>