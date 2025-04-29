<?php
session_start();
include 'db.php';

// Periksa apakah pengguna adalah admin
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Tambahkan fungsi logout
if (isset($_GET['logout'])) {
    session_unset(); // Menghapus semua variabel sesi
    session_destroy(); // Menghancurkan sesi
    header("Location: login_admin.php"); // Arahkan ke halaman login
    exit;
}

// Query untuk mengambil data dari tabel talent
$result_talent = $conn->query("SELECT * FROM talent");
if (!$result_talent) {
    die("Query talent gagal: " . $conn->error);
}

// Query untuk mengambil data dari tabel inventaris
$result_inventaris = $conn->query("SELECT * FROM inventaris");
if (!$result_inventaris) {
    die("Query inventaris gagal: " . $conn->error);
}

// Query untuk mengambil data dari tabel pengurus
$result_pengurus = $conn->query("SELECT * FROM pengurus");
if (!$result_pengurus) {
    die("Query pengurus gagal: " . $conn->error);
}

// Fungsi CRUD hanya untuk admin
if ($is_admin) {
    // Fungsi Tambah Data Talent
    if (isset($_POST['create'])) {
        $jenis_talent = $conn->real_escape_string($_POST['jenis_talent']);
        $keterangan = $conn->real_escape_string($_POST['keterangan']);

        $sql = "INSERT INTO talent (jenis_talent, keterangan) VALUES ('$jenis_talent', '$keterangan')";
        if ($conn->query($sql) === TRUE) {
            header("Location: beranda.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if (isset($_POST['delete'])) {
        $id_talent = intval($_POST['id_talent']); // Ambil ID Talent dari input field
    
        // Query Delete
        $sql = "DELETE FROM talent WHERE id_talent=$id_talent";
        if ($conn->query($sql) === TRUE) {
            header("Location: beranda.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    if (isset($_POST['update'])) {
        $id_talent = intval($_POST['id_talent']); // Ambil ID Talent dari input field
    
        // Periksa apakah ID Talent ada di database
        $query = "SELECT * FROM talent WHERE id_talent=$id_talent";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
    
            // Gunakan nilai asli jika input kosong
            $jenis_talent = !empty($_POST['jenis_talent']) ? $conn->real_escape_string($_POST['jenis_talent']) : $row['jenis_talent'];
            $keterangan = !empty($_POST['keterangan']) ? $conn->real_escape_string($_POST['keterangan']) : $row['keterangan'];
    
            // Query Update
            $sql = "UPDATE talent SET jenis_talent='$jenis_talent', keterangan='$keterangan' WHERE id_talent=$id_talent";
            if ($conn->query($sql) === TRUE) {
                header("Location: beranda.php");
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: Data talent dengan ID $id_talent tidak ditemukan.";
        }
    }

    // Fungsi Tambah Data Pengurus
    if (isset($_POST['create_pengurus'])) {
        $nama_pengurus = $conn->real_escape_string($_POST['nama_pengurus']);
        $nim = $conn->real_escape_string($_POST['nim']);
        $angkatan = intval($_POST['angkatan']);
        $jabatan = $conn->real_escape_string($_POST['jabatan']);
        $kontak = $conn->real_escape_string($_POST['kontak']);

        $sql = "INSERT INTO pengurus (nama_pengurus, nim, angkatan, jabatan, kontak) VALUES ('$nama_pengurus', '$nim', $angkatan, '$jabatan', '$kontak')";
        if ($conn->query($sql) === TRUE) {
            header("Location: beranda.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fungsi Hapus Data Pengurus
    if (isset($_GET['delete_pengurus'])) {
        $id_pengurus = intval($_GET['delete_pengurus']); // Ganti 'id' dengan 'id_pengurus'

        $sql = "DELETE FROM pengurus WHERE id_pengurus=$id_pengurus";
        if ($conn->query($sql) === TRUE) {
            header("Location: beranda.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fungsi Update Data Pengurus
    if (isset($_POST['update_pengurus'])) {
        $id_pengurus = intval($_POST['id_pengurus']); // Ganti 'id' dengan 'id_pengurus'
        $nama_pengurus = $conn->real_escape_string($_POST['nama_pengurus']);
        $nim = $conn->real_escape_string($_POST['nim']);
        $angkatan = intval($_POST['angkatan']);
        $jabatan = $conn->real_escape_string($_POST['jabatan']);
        $kontak = $conn->real_escape_string($_POST['kontak']);

        $sql = "UPDATE pengurus SET nama_pengurus='$nama_pengurus', nim='$nim', angkatan=$angkatan, jabatan='$jabatan', kontak='$kontak' WHERE id_pengurus=$id_pengurus";
        if ($conn->query($sql) === TRUE) {
            header("Location: beranda.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fungsi Tambah Data Inventaris
    if (isset($_POST['create_inventaris'])) {
        $nama_item = $conn->real_escape_string($_POST['nama_item']);
        $harga_sewa = intval($_POST['harga_sewa']);

        $sql = "INSERT INTO inventaris (nama_item, harga_sewa) VALUES ('$nama_item', $harga_sewa)";
        if ($conn->query($sql) === TRUE) {
            header("Location: beranda.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fungsi Hapus Data Inventaris
    if (isset($_GET['delete_inventaris'])) {
        $id_item = intval($_GET['delete_inventaris']); // Ganti 'id' dengan 'id_item'

        $sql = "DELETE FROM inventaris WHERE id_item=$id_item";
        if ($conn->query($sql) === TRUE) {
            header("Location: beranda.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fungsi Update Data Inventaris
    if (isset($_POST['update_inventaris'])) {
        $id_item = intval($_POST['id_item']); // Ganti 'id' dengan 'id_item'
        $nama_item = $conn->real_escape_string($_POST['nama_item']);
        $harga_sewa = intval($_POST['harga_sewa']);

        $sql = "UPDATE inventaris SET nama_item='$nama_item', harga_sewa=$harga_sewa WHERE id_item=$id_item";
        if ($conn->query($sql) === TRUE) {
            header("Location: beranda.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Website Sanggar Birama</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Website Sanggar Birama</title>
</head>
<body>
    <div class="form-container">
        <header>
        <h1>Selamat Datang di Website Sanggar Birama</h1>
        <?php if ($is_admin): ?>
            <a href="logout_admin.php">Logout</a>
        <?php else: ?>
            <a href="login_admin.php">Login Admin</a>
        <?php endif; ?>
        </header>
        <div class="content">
            <div class="intro">
                <h2>Tentang Sanggar Birama</h2>
                <p>Sanggar Birama adalah sebutan untuk divisi gerak dalam Unit Kegiatan Mahasiswa (UKMU) Seni dan Budaya Universitas Mataram, yang memiliki dua fokus yaitu gerak Tradisional dan gerak Modern. Dengan tujuan melestarikan dan mengembangkan seni tari tradisional maupun modern di Indonesia.

Birama menyediakan berbagai talent di bidang gerak tari dan dance, serta menyewakan alat dan kostum untuk berbagai kebutuhan pertunjukan dan event.</p>
            </div>

            <h2>Talent yang Tersedia</h2>
            <table border="1">
                <tr>
                    <th>No</th>
                    <th>ID Talent</th>
                    <th>Jenis Talent</th>
                    <th>Keterangan</th>
                    <?php if ($is_admin): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
                <?php $no = 1; while ($row = $result_talent->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['id_talent'] ?></td>
                    <td><?= htmlspecialchars($row['jenis_talent']) ?></td>
                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                    <?php if ($is_admin): ?>
                    <td>
                        <!-- Form Update -->
                        <form method="post" style="display:inline-block;">
                            <label>ID Talent:</label>
                            <input type="text" name="id_talent" value="<?= $row['id_talent'] ?>" readonly> <!-- Input ID -->
                            <input type="text" name="jenis_talent" value="<?= htmlspecialchars($row['jenis_talent']) ?>">
                            <input type="text" name="keterangan" value="<?= htmlspecialchars($row['keterangan']) ?>">
                            <button type="submit" name="update">Update</button>
                        </form>
                        <!-- Form Hapus -->
                        <form method="post" style="display:inline-block;">
                            <label>ID Talent:</label>
                            <input type="text" name="id_talent" placeholder="Masukkan ID Talent">
                            <button onclick="confirmDeleteTalent(<?= $row['id_talent'] ?>)">Hapus</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </table>
            <?php if ($is_admin): ?>
            <h3>Tambah Talent Baru</h3>
            <form method="post">
                <label>ID Talent:</label>
                <input type="text" name="id_talent" placeholder="Masukkan ID Talent" required> <!-- Input ID Talent -->
                <label>Jenis Talent:</label>
                <input type="text" name="jenis_talent" placeholder="Jenis Talent" required>
                <label>Keterangan:</label>
                <input type="text" name="keterangan" placeholder="Keterangan" required>
                <button type="submit" name="create">Tambah</button>
            </form>
            <?php endif; ?>

            <h2>Alat dan Kostum yang Disewakan</h2>
            <table border="1">
                <tr>
                    <th>No</th>
                    <th>ID Inventaris</th>
                    <th>Nama Item</th>
                    <th>Harga Sewa</th>
                    <?php if ($is_admin): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
                <?php $no = 1; while ($row = $result_inventaris->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['id_item'] ?></td>
                    <td><?= htmlspecialchars($row['nama_item']) ?></td>
                    <td>Rp <?= number_format($row['harga_sewa'], 0, ',', '.') ?>/hari</td>
                    <?php if ($is_admin): ?>
                    <td>
                        <!-- Form Update -->
                        <form method="post" style="display:inline-block;">
                            <label>ID Inventaris:</label>
                            <input type="text" name="id_item" value="<?= $row['id_item'] ?>" readonly> <!-- Input ID -->
                            <input type="text" name="nama_item" value="<?= htmlspecialchars($row['nama_item']) ?>">
                            <input type="number" name="harga_sewa" value="<?= htmlspecialchars($row['harga_sewa']) ?>">
                            <button type="submit" name="update_inventaris">Update</button>
                        </form>
                        <!-- Form Hapus -->
                        <form method="post" style="display:inline-block;">
                            <label>ID Inventaris:</label>
                            <input type="text" name="id_item" placeholder="Masukkan ID Inventaris">
                            <button onclick="confirmDeleteInventaris(<?= $row['id_item'] ?>)">Hapus</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </table>
        
            <?php if ($is_admin): ?>
            <h3>Tambah Alat atau Kostum Baru</h3>
            <form method="post">
                <label>ID Inventaris:</label>
                <input type="text" name="id_item" placeholder="Masukkan ID Inventaris" required> <!-- Input ID Inventaris -->
                <label>Nama Item:</label>
                <input type="text" name="nama_item" placeholder="Nama Item" required>
                <label>Harga Sewa:</label>
                <input type="number" name="harga_sewa" placeholder="Harga Sewa (per hari)" required>
                <button type="submit" name="create_inventaris">Tambah</button>
            </form>
            <?php endif; ?>

            <h2>Pengurus Sanggar Seni Tahun 2025</h2>
            <table border="1">
                <tr>
                    <th>No</th>
                    <th>ID Pengurus</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Angkatan</th>
                    <th>Jabatan</th>
                    <th>Kontak</th>
                    <?php if ($is_admin): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
                <?php $no = 1; while ($row = $result_pengurus->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['id_pengurus'] ?></td>
                    <td><?= htmlspecialchars($row['nama_pengurus']) ?></td>
                    <td><?= htmlspecialchars($row['nim']) ?></td>
                    <td><?= htmlspecialchars($row['angkatan']) ?></td>
                    <td><?= htmlspecialchars($row['jabatan']) ?></td>
                    <td><?= htmlspecialchars($row['kontak']) ?></td>
                    <?php if ($is_admin): ?>
                    <td>
                        <form method="post" style="display:inline-block;">
                            <label>ID Pengurus:</label>
                            <input type="text" name="id_pengurus" value="<?= $row['id_pengurus'] ?>" readonly> <!-- Input ID -->
                            <input type="text" name="nama_pengurus" value="<?= htmlspecialchars($row['nama_pengurus']) ?>">
                            <input type="text" name="nim" value="<?= htmlspecialchars($row['nim']) ?>">
                            <input type="number" name="angkatan" value="<?= htmlspecialchars($row['angkatan']) ?>">
                            <input type="text" name="jabatan" value="<?= htmlspecialchars($row['jabatan']) ?>">
                            <input type="text" name="kontak" value="<?= htmlspecialchars($row['kontak']) ?>">
                            <button type="submit" name="update_pengurus">Update</button>
                        </form>
                        <form method="post" style="display:inline-block;">
                            <label>ID Pengurus:</label>
                            <input type="text" name="id_pengurus" placeholder="Masukkan ID Pengurus">
                            <button type="submit" name="delete_pengurus">Hapus</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </table>
            <?php if ($is_admin): ?>
    <h3>Tambah Pengurus Baru</h3>
    <form method="post">
        <label>ID Pengurus:</label>
        <input type="text" name="id_pengurus" placeholder="Masukkan ID Pengurus" required> <!-- Input ID Pengurus -->
        <label>Nama:</label>
        <input type="text" name="nama_pengurus" placeholder="Nama" required>
        <label>NIM:</label>
        <input type="text" name="nim" placeholder="NIM" required>
        <label>Angkatan:</label>
        <input type="number" name="angkatan" placeholder="Angkatan" required>
        <label>Jabatan:</label>
        <input type="text" name="jabatan" placeholder="Jabatan" required>
        <label>Kontak:</label>
        <input type="text" name="kontak" placeholder="Kontak" required>
        <button type="submit" name="create_pengurus">Tambah</button>
    </form>
    <?php endif; ?>

            <h2>Portofolio dan Layanan</h2>
            <a href="portofolio.html" target="_blank">Lihat Portofolio</a><br>
            <a href="formSewa.html" target="_blank">Formulir Penyewaan Alat & Kostum</a><br>
            <a href="bookTalent.html" target="_blank">Formulir Penyewaan Talent</a>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Sanggar Birama - UKM Seni dan Budaya Universitas Mataram</p>
    </footer>
</body>
</html>