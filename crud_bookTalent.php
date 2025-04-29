<?php
// filepath: d:\dari c\2Xampp\instal\htdocs\pw25-minggu7-crud\crud_booking.php
include 'db.php';

// Fungsi Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_client = $_POST['nama_client'];
    $email = $_POST['email'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $jenis_talent = $_POST['jenis_talent'];
    $jumlah_talent = $_POST['jumlah_talent'];
    $tanggal_acara = $_POST['tanggal_acara'];
    $lokasi = $_POST['lokasi'];
    $durasi = $_POST['durasi'];

    $sql = "INSERT INTO crud_006_bookTalent (nama_client, email, nama_kegiatan, jenis_talent, jumlah_talent, tanggal_acara, lokasi, durasi) 
            VALUES ('$nama_client', '$email', '$nama_kegiatan', '$jenis_talent', $jumlah_talent, '$tanggal_acara', '$lokasi', $durasi)";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
    }
}

// Menampilkan Data
$result = $conn->query("SELECT * FROM crud_006_bookTalent");
?>





