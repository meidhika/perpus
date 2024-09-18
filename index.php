<?php
session_start();
include 'function/helper.php';
include 'config/koneksi.php';
$queryUser = mysqli_query($koneksi, "SELECT * FROM user");
$rowUser = mysqli_fetch_assoc($queryUser);
$queryLevel = mysqli_query($koneksi, "SELECT * FROM level");
$rowLevel = mysqli_fetch_assoc($queryLevel);
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori");
$rowKategori = mysqli_fetch_assoc($queryKategori);
// echo "<h1>Selamat datang " . (isset($_SESSION['NAMA_LENGKAP']) ? $_SESSION['NAMA_LENGKAP'] : '') . "</h1>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang, <?= $rowUser['nama_lengkap'] ?> </title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            /* background-image: url('assets/img/luxury.jpg'); */
            /* background-size: cover; */
        }

        nav.menu {

            box-shadow: 0px 0px 3px black;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav class="menu navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Perpustakaan</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="content/home.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Master Data
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="?pg=anggota">Anggota</a></li>
                                <li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="?pg=buku">Buku</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="?pg=kategori">Kategori</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li><a class="dropdown-item" href="?pg=user">User</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="?pg=level">Level</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pg=peminjaman">Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?pg=pengembalian">Pengembalian</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <a href="login.php" class="btn btn-primary">Login</a>
                        <a href="logout.php" class="btn btn-outline-danger mx-3">Logout</a>
                    </form>
                </div>
            </div>
        </nav>

        <!-- content here -->
        <?php
        if (isset($_GET['pg'])) {
            if (file_exists('content/' . $_GET['pg'] . '.php')) {
                include 'content/' . $_GET['pg'] . '.php';
            } else {
                include 'content/home.php';
            }
        }

        ?>

        <!-- end content -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/moment.js"></script>

    <script>
        $('#id_kategori').change(function() {
            let id = $(this).val(),
                option = "";
            $.ajax({
                url: `ajax/get-buku.php?id_kategori=${id}`,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    option += "<option value=''>Pilih Buku</option>"
                    $.each(data, function(key, value) {
                        let tahun_terbit = $('#tahun_terbit').val(value.tahun_terbit);
                        // option += "<option value=" + value.id + ">" + value.judul + "</option>"
                        option += `<option value=${value.id}> ${value.judul}</option>`
                        // console.log("Valuenya : ", value.judul);
                    });
                    $('#id_buku').html(option);


                }
            })
        });
        $('#tambah-row').click(function() {
            if ($('#id_kategori').val() == "") {
                alert('Mohon pilih kategori buku terlebih dahulu');
                return false;
            }
            if ($('#id_buku').val() == "") {
                alert('Mohon pilih buku terlebih dahulu');
                return false;
            }
            let nama_kategori = $('#id_kategori').find('option:selected').text(),
                nama_buku = $('#id_buku').find('option:selected').text(),
                tahun_terbit = $('#tahun_terbit').val(),
                id_kategori = $('#id_kategori').val(),
                id_buku = $('#id_buku').val();

            let tbody = $('tbody');
            let no = tbody.find('tr').length + 1;
            let table = "<tr>";
            table += `<td> ${no}</td>`
            table += `<td>${nama_kategori} <input type="hidden" name="id_kategori[]" value="${id_kategori}"></td>`
            table += `<td>${nama_buku} <input type="hidden" name="id_buku[]" value="${id_buku}"></td>`
            table += `<td>${tahun_terbit}</td>`
            table += `<td><button type="button" class="remove btn btn-sm btn-danger">Delete</button></td>`
            table += `</tr>`;
            tbody.append(table);

            $('#id_kategori').val('');
            $('#id_buku').html("<option value=''>Pilih Buku</option>");
            $('#tahun_terbit').val('');

            $('.remove').click(function() {
                $(this).closest('tr').remove();
            });



        });
        $('#kode_peminjaman').change(function() {
            

            let id = $(this).val();
            $.ajax({
                url: `ajax/get-data-transaksi.php?kode_transaksi=${id}`,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    // console.log("Nilai sebelum di looping", data);
                    $('#nama_anggota').val(data.data.nama_lengkap);
                    $('#tgl_pinjam').val(data.data.tgl_pinjam);
                    $('#tgl_kembali ').val(data.data.tgl_kembali);
                    let pengembalian = $('#tgl_pengembalian').val();

                    let tanggal_kembali = new moment(data.data.tgl_kembali);
                    let tanggal_pengembalian = new moment(pengembalian);
                    let selisih = tanggal_pengembalian.diff(tanggal_kembali, 'days');
                    let terlambat = tanggal_pengembalian.diff(tanggal_kembali, 'days');
                    let denda = 1000000;
                    
                    if (selisih <= 0) {
                        terlambat = "Tidak Terlambat";
                        selisih = 0;
                    } else if (selisih > 0) {
                        
                        terlambat = "Terlambat " + terlambat + " Hari";
                    }
                    let totalDenda = selisih * denda;
                    $('#terlambat').val(terlambat);
                    $('#denda').val(totalDenda);

                    $('.total-denda').html("<h5> Rp." + totalDenda.toLocaleString('id-ID') + "</h5>")
                    let tbody = $('tbody'),
                        newRow = "";
                    let no = tbody.find('tr').length + 1;
                    $.each(data.detail_pinjam, function(index, val) {

                        newRow += "<tr>";
                        newRow += "<td>" + no++ + "</td>";
                        newRow += "<td>" + val.nama_kategori + "</td>";
                        newRow += "<td>" + val.judul + "</td>";
                        newRow += "<td>" + val.tahun_terbit + "</td>";
                        newRow += "</tr>";
                    });
                    tbody.html(newRow);


                }
            })
        });

        function toggleTransactionCode() {
            const tgl_pengembalian = document.getElementById('tgl_pengembalian').value;
            const Kode_peminjaman = document.getElementById('kode_peminjaman');

            if (tgl_pengembalian === '') {
                kode_peminjaman.disabled = true;
                kode_peminjaman.selectedIndex = 0; // Reset pilihan jika dinonaktifkan
            } else {
                kode_peminjaman.disabled = false;
            }
        }

        
    </script>
</body>

</html>