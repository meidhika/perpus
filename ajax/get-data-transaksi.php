<?php
include '../config/koneksi.php';

if (isset($_GET['kode_transaksi'])) {
    $id = $_GET['kode_transaksi'];
    $queryTrans = mysqli_query($koneksi, "SELECT * FROM peminjaman LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota WHERE peminjaman.id ='$id'");
    $rowPeminjam = mysqli_fetch_assoc($queryTrans);


    $queryDetailPinjam = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman 
    LEFT JOIN kategori ON kategori.id = detail_peminjaman.id_kategori
    LEFT JOIN buku ON buku.id = detail_peminjaman.id_buku WHERE id_peminjaman = '$id'");

    while ($rowDetailPinjam = mysqli_fetch_assoc($queryDetailPinjam)) {
        $dataDetailPinjam[] = $rowDetailPinjam;
    }


    // print_r($dataDetailPinjam);
    // die;

    $respon = json_encode([
        'data' => $rowPeminjam,
        'detail_pinjam' => $dataDetailPinjam
    ]);

    echo $respon;
}
