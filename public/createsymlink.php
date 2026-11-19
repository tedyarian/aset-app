<?php
// Script untuk membuat symlink storage secara manual yang benar
$target = $_SERVER['DOCUMENT_ROOT'] . '/storage'; // Mengarah ke public_html/storage

// Mundur satu tingkat dari public_html (../) lalu masuk ke folder aset-app
$origin = realpath(__DIR__ . '/../aset-app/storage/app/public'); 

if (file_exists($target)) {
    if (is_link($target)) {
        echo "Symlink sudah ada dan aktif!";
    } else {
        rmdir($target); // Hapus jika terlanjur jadi folder fisik
        if (symlink($origin, $target)) {
            echo "Berhasil menghapus folder fisik dan sukses membuat symlink baru!";
        } else {
            echo "Gagal membuat symlink. Periksa izin folder.";
        }
    }
} else {
    if (symlink($origin, $target)) {
        echo "Berhasil membuat symlink storage!";
    } else {
        echo "Gagal membuat symlink.";
    }
}
?>