<?php

if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $edit = mysqli_query($koneksi, "SELECT * FROM level WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($edit);
}

if (isset($_POST['simpan'])){
    // jika param edit ada maka update, selain itu maka tambah
    $id = isset($_GET['edit']) ? $_GET['edit']:'';
    
    $nama_level = $_POST['nama_level'];
    $keterangan = $_POST['keterangan'];

    if (!$id) {
        $insert = mysqli_query($koneksi, "INSERT INTO level (nama_level, keterangan) VALUES ('$nama_level','$keterangan')");
    }else{
        $update = mysqli_query($koneksi, "UPDATE level SET nama_level = '$nama_level', keterangan = '$keterangan' WHERE id = '$id'");
    }


    header("location:?pg=level&tambah=berhasil");
}

if (isset($_GET['delete'])){
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM level WHERE id = '$id'");
    header("location:?pg=level&hapus=berhasil");
}

?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card">
                <div class="card-header">Data Level</div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Level</label>
                            <input value="<?= $rowEdit['nama_level'] ?? '' ;?>" type="text" class="form-control" id="" name="nama_level">

                            <label for="" class="form-label">Keterangan</label>
                            <input value="<?= $rowEdit['keterangan'] ?? '' ;?>"type="text" class="form-control" id="" name="keterangan">

                            <input name="simpan" value="Simpan" type="submit" class="btn btn-primary mt-3"></input>
                            <a href="?pg=level" class="btn btn-danger mt-3 mx-1" id="back">Kembali</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>