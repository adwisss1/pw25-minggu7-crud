<?php
// filepath: d:\dari c\2Xampp\instal\htdocs\pw25-minggu7-crud\crud_penyewaan.php
include 'db.php';

// Fungsi Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_penyewa = $_POST['nama'];
    $email = $_POST['email'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $telepon = $_POST['telepon'];
    $item = $_POST['item'];
    $tanggal_penyewaan = $_POST['tanggal'];
    $durasi = $_POST['durasi'];

    $sql = "INSERT INTO crud_006_penyewaan (nama_penyewa, email, nama_kegiatan, telepon, item, tanggal_penyewaan, durasi) 
            VALUES ('$nama_penyewa', '$email', '$nama_kegiatan', '$telepon', '$item', '$tanggal_penyewaan', $durasi)";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data penyewaan berhasil disimpan!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
    }
}

// Menampilkan Data
$result = $conn->query("SELECT * FROM crud_006_penyewaan");
?>