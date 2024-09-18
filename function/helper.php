<?php
function getStatus($status)
{
    switch ($status) {
        case '1':
            $label = '<div class="badge text-bg-primary">Sedang dipinjam</div>';
            break;
        case '2':
            $label = '<span class="badge text-bg-success">Sudah dikembalikan</span>';
            break;

        default:
            $label = "";
            break;
    }
    return $label;
}
function getKeterlambatan($hari_terlambat)
{
    if ($hari_terlambat <= 0) {
        $label =  '<span class="badge text-bg-success">Tidak Terlambat</span>';
    } else {
        $label =  '<span class="badge text-bg-danger">Terlambat</span>';
    }
    return $label;
}
