<?php

require('config.php');



if (isset($_POST['submit'])) {
    $nama_pelapor = $_POST['nama_pelapor'];
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $lokasi = $_POST['lokasi'];
    $id_kategori = $_POST['id_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $prioritas = $_POST['prioritas'];

    $query = "INSERT INTO laporan_kerusakan (nama_pelapor, nama_fasilitas, lokasi, id_kategori, deskripsi, prioritas) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->execute([$nama_pelapor, $nama_fasilitas, $lokasi, $id_kategori, $deskripsi, $prioritas]);

    }

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Kerusakan Fasilitas Sekolah</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        body, input, textarea, select, button {
            font-family: 'Poppins', sans-serif;
        }
    </style>

</head>
<body>
    <!-- Bagian ini merupakan starter HTML. Belum ada koneksi database ataupun query. -->
    <header class="bg-blue-500 text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-8 md:px-8">
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="mt-2 text-2xl md:text-4xl font-bold">Pelaporan Kerusakan Fasilitas Sekolah</h1>
                </div>
                <nav aria-label="Navigasi utama" class="flex flex-wrap gap-3 text-sm font-medium">
                    <a href="#form-laporan" class="rounded border border-white/30 bg-white/10 px-4 py-2 hover:bg-white/20 transition">Buat Laporan</a>
                    <a href="#daftar-laporan" class="rounded border border-white/30 bg-white/10 px-4 py-2 hover:bg-white/20 transition">Daftar Laporan</a>
                </nav>
            </div>
            <p class="mt-5 max-w-2xl text-blue-100 text-sm md:text-base">Catat dan pantau laporan kerusakan fasilitas sekolah agar penanganan dapat dilakukan lebih cepat dan terorganisir.</p>
        </div>
    </header>

    <main>
        <section class="" id="form-laporan" aria-labelledby="judul-form">
            <h2 id="judul-form">Form Pelaporan Kerusakan</h2>
            <p>Lengkapi data berikut untuk melaporkan fasilitas yang rusak.</p>

            <!-- TANTANGAN BONUS CREATE: Buat proses PHP agar POST menyimpan data. -->
            <form action="" method="post" class="bg-gray-100 p-4 rounded shadow-md">
                <fieldset>
                    <legend class="font-bold mb-4">Data Pelaporan</legend>

                    <div class="mb-4">
                        <label for="nama_pelapor">Nama pelapor</label>
                        <input class="border rounded" type="text" id="nama_pelapor" name="nama_pelapor" maxlength="100" required>
                    </div>

                    <div class="mb-4">
                        <label for="nama_fasilitas">Nama fasilitas</label>
                        <input type="text" id="nama_fasilitas" name="nama_fasilitas" maxlength="100" required>
                    </div>

                    <div class="mb-4">
                        <label for="lokasi">Lokasi kerusakan</label>
                        <input type="text" id="lokasi" name="lokasi" maxlength="100" required>
                    </div>

                    <div class="mb-4">
                        <label for="id_kategori">Kategori fasilitas</label>
                        <select id="id_kategori" name="id_kategori" required>
                            <option value="">-- Pilih kategori --</option>
                            <!-- Nilai berikut sesuai dengan data awal kategori_fasilitas. -->
                            <option value="1">Elektronik</option>
                            <option value="2">Furnitur</option>
                            <option value="3">Jaringan</option>
                            <option value="4">Peralatan Kelas</option>
                        </select>
                    </div>

                    <p>
                        <label for="deskripsi">Deskripsi kerusakan</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    </p>

                    <p>
                        <label for="prioritas">Prioritas</label>
                        <select id="prioritas" name="prioritas" required>
                            <option value="">-- Pilih prioritas --</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </p>

                    <p><button type="submit">Kirim Laporan</button></p>
                </fieldset>
            </form>
            <p><small>Catatan: tombol Kirim Laporan belum menyimpan apa pun. Fitur Create merupakan tantangan bonus.</small></p>
        </section>

        <section id="daftar-laporan" aria-labelledby="judul-daftar">
            <h2 id="judul-daftar">Daftar Laporan Kerusakan</h2>
            <p>Seluruh laporan yang tercatat pada database ditampilkan di bagian ini.</p>

            <!-- TANTANGAN WAJIB:
                 1. Buat sendiri koneksi PHP ke MySQL.
                 2. Jalankan query SELECT untuk mengambil data dari laporan_kerusakan.
                 3. Ganti baris placeholder pada tbody dengan perulangan hasil query.
                 4. Jangan mengetik data database secara manual di HTML.
            -->
            <table>
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Fasilitas</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Pelapor</th>
                        <th scope="col">Prioritas</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        if ($conn) {
                            $query = "SELECT * FROM laporan_kerusakan";
                            $stmt = $conn->query($query);
                            $laporan = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($laporan as $index => $row) {
                                echo "<tr>";
                                echo "<td>" . ($index + 1) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_fasilitas']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['lokasi']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_pelapor']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['prioritas']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                // echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Koneksi database gagal.</td></tr>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Sistem Pelaporan Kerusakan Fasilitas Sekolah.</p>
    </footer>
</body>
</html>
