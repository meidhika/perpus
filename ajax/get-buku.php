<?php

include '../config/koneksi.php';


$id_kategori = ($_GET['id_kategori'] ?? '');

$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_kategori = '$id_kategori'");
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);
