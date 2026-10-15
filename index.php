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


$laporan = [];

if ($conn) {
    $query = "SELECT l.*, k.nama_kategori
              FROM laporan_kerusakan as l
              JOIN kategori_fasilitas as k ON l.id_kategori = k.id_kategori
              ORDER BY l.tanggal_laporan DESC";
    $stmt = $conn->query($query);
    $laporan = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        body {
            background-color: #f3f4f6;
            color: #1f2937;
        }
    </style>

</head>
<body>
    <header class="bg-blue-600 text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-8 md:px-8">
            <div class="flex flex-col gap-5">
                <div class="flex flex-col">
                    <h1 class="mt-2 text-2xl md:text-4xl font-bold">Pelaporan Kerusakan Fasilitas Sekolah</h1>
                    <p class="mt-5 max-w-2xl text-blue-100 text-sm md:text-base">Catat dan pantau laporan kerusakan fasilitas sekolah agar penanganan dapat dilakukan lebih cepat dan terorganisir.</p>
                </div>
                <nav aria-label="Navigasi utama" class="flex flex-wrap gap-3 text-sm font-medium">
                    <a href="#form-laporan" class="rounded border border-white/30 bg-white/10 px-4 py-2 hover:bg-white/20 transition">Buat Laporan</a>
                    <a href="#daftar-laporan" class="rounded border border-white/30 bg-white/10 px-4 py-2 hover:bg-white/20 transition">Daftar Laporan</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8 md:px-8 bg-white shadow-md rounded-3xl mt-8">
        <section class="" id="form-laporan" aria-labelledby="judul-form" class="mb-8">
            <div class="mb-4">
                <h2 id="judul-form" class="text-xl font-bold">Form Pelaporan Kerusakan</h2>
                <p>Lengkapi data berikut untuk melaporkan fasilitas yang rusak.</p>
            </div>

            <!-- TANTANGAN BONUS CREATE: Buat proses PHP agar POST menyimpan data. -->
            <form action="" method="post" class="bg-white p-4 rounded shadow-md border border-gray-300 mt-4">
                <fieldset>
                    <legend class="font-bold mb-4">Data Pelaporan</legend>

                    <div class="mb-4">
                        <label for="nama_pelapor" class="font-semibold block">Nama pelapor</label>
                        <input class="border rounded mt-3" type="text" id="nama_pelapor" name="nama_pelapor" maxlength="100" required>
                    </div>

                    <div class="mb-4">
                        <label for="nama_fasilitas" class="font-semibold block">Nama fasilitas</label>
                        <input class="border rounded mt-3" type="text" id="nama_fasilitas" name="nama_fasilitas" maxlength="100" required>
                    </div>

                    <div class="mb-4">
                        <label for="lokasi" class="font-semibold block">Lokasi kerusakan</label>
                        <input class="border rounded mt-3" type="text" id="lokasi" name="lokasi" maxlength="100" required>
                    </div>

                    <div class="mb-4">
                        <label for="id_kategori" class="font-semibold block">Kategori fasilitas</label>
                        <select class="border rounded mt-3 p-1" id="id_kategori" name="id_kategori" required>
                            <option value=""> Pilih kategori </option>
                            <!-- Nilai berikut sesuai dengan data awal kategori_fasilitas. -->
                            <option value="1">Elektronik</option>
                            <option value="2">Furnitur</option>
                            <option value="3">Jaringan</option>
                            <option value="4">Peralatan Kelas</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="font-semibold block">Deskripsi kerusakan</label>
                        <textarea class="border rounded mt-3" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="prioritas" class="font-semibold block">Prioritas</label>
                        <select class="border rounded mt-3 p-1" id="prioritas" name="prioritas" required>
                            <option value=""> Pilih prioritas </option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <p><button type="submit" name="submit" class="font-md bg-blue-500 p-3 rounded-xl text-white mt-2 rounded hover:bg-blue-600">Kirim Laporan</button></p>
                    </div>
                </fieldset>
            </form>
            <!-- <p><small>Catatan: tombol Kirim Laporan belum menyimpan apa pun. Fitur Create merupakan tantangan bonus.</small></p> -->
        </section>

        <section id="daftar-laporan" aria-labelledby="judul-daftar" class="mt-8">
            <div class="mb-8">
                <h2 id="judul-daftar" class="font-bold text-xl">Daftar Laporan Kerusakan</h2>
                <p>Seluruh laporan yang tercatat pada database ditampilkan di bagian ini.</p>
            </div>

            <!-- TANTANGAN WAJIB:
                 1. Buat sendiri koneksi PHP ke MySQL.
                 2. Jalankan query SELECT untuk mengambil data dari laporan_kerusakan.
                 3. Ganti baris placeholder pada tbody dengan perulangan hasil query.
                 4. Jangan mengetik data database secara manual di HTML.
            -->
            <div class="overflow-x-auto rounded-xl border border-gray">
                <table class="min-w-full text-left">
                    <thead class="bg-blue-500">
                        <tr>
                            <th scope="col" class="px-4 py-4 text-white">No.</th>
                            <th scope="col" class="px-4 py-4 text-white">Fasilitas</th>
                            <th scope="col" class="px-4 py-4 text-white">Lokasi</th>
                            <th scope="col" class="px-4 py-4 text-white">Pelapor</th>
                            <th scope="col" class="px-4 py-4 text-white">Prioritas</th>
                            <th scope="col" class="px-4 py-4 text-white">Status</th>
                            <th scope="col" class="px-4 py-4 text-white">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($laporan)): ?> 
                            <?php foreach($laporan as $index => $row): ?>
                                <tr class="">
                                    <td class="px-4 py-4"><?php echo $index + 1; ?></td>
                                    <td class="px-4 py-4"><?php echo htmlspecialchars($row['nama_fasilitas']); ?></td>
                                    <td class="px-4 py-4"><?php echo htmlspecialchars($row['lokasi']); ?></td>
                                    <td class="px-4 py-4"><?php echo htmlspecialchars($row['nama_pelapor']); ?></td>
                                    <td class="px-4 py-4"><?php echo htmlspecialchars($row['prioritas']); ?></td>
                                    <td class="px-4 py-4"><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td class="px-4 py-4"><?php echo htmlspecialchars(date('d-m-Y', strtotime($row['tanggal_laporan']))); ?></td>
                                </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-slate-500">Belum ada laporan yang tercatat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                    <!-- <tbody class="bg-white">
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
                                echo "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['tanggal_laporan']))) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Koneksi database gagal.</td></tr>";
                        }
                        ?>
                    </tbody> -->
                </table>
            </div>

        </section>
    </main>

    <footer>
        <p>&copy; 2024 Sistem Pelaporan Kerusakan Fasilitas Sekolah.</p>
    </footer>
</body>
</html>
