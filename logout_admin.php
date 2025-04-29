<?php
session_start(); // Memulai sesi
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghancurkan sesi
header("Location: beranda.php"); // Arahkan ke halaman beranda tanpa fitur CRUD
exit;
?>