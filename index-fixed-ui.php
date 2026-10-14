<?php

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nama_pelapor = trim($_POST['nama_pelapor'] ?? '');
    $nama_fasilitas = trim($_POST['nama_fasilitas'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? '');
    $id_kategori = $_POST['id_kategori'] ?? '';
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $prioritas = $_POST['prioritas'] ?? '';

    if ($nama_pelapor !== '' && $nama_fasilitas !== '' && $lokasi !== '' && $id_kategori !== '' && $deskripsi !== '' && $prioritas !== '') {
        $query = "INSERT INTO laporan_kerusakan (nama_pelapor, nama_fasilitas, lokasi, id_kategori, deskripsi, prioritas) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->execute([$nama_pelapor, $nama_fasilitas, $lokasi, $id_kategori, $deskripsi, $prioritas]);
    }
}

$laporan = [];
if ($conn) {
    $query = "SELECT l.*, k.nama_kategori
              FROM laporan_kerusakan l
              JOIN kategori_fasilitas k ON l.id_kategori = k.id_kategori
              ORDER BY l.tanggal_laporan DESC";
    $stmt = $conn->query($query);
    $laporan = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function badgeStatus($status) {
    $map = [
        'Menunggu' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'Diproses' => 'bg-blue-100 text-blue-800 border-blue-200',
        'Selesai' => 'bg-green-100 text-green-800 border-green-200',
    ];

    return $map[$status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
}

function badgePrioritas($prioritas) {
    $map = [
        'Rendah' => 'bg-slate-100 text-slate-700 border-slate-200',
        'Sedang' => 'bg-amber-100 text-amber-700 border-amber-200',
        'Tinggi' => 'bg-red-100 text-red-700 border-red-200',
    ];

    return $map[$prioritas] ?? 'bg-gray-100 text-gray-700 border-gray-200';
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --bg-soft: #f8fbff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #eff6ff 0%, #f8fafc 100%);
        }

        .glass {
            backdrop-filter: blur(6px);
        }
    </style>
</head>
<body class="text-slate-800">
    <header class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-8 md:px-8">
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.22em] text-blue-100 font-medium">Sistem Informasi</p>
                    <h1 class="mt-2 text-2xl md:text-4xl font-bold">Pelaporan Kerusakan Fasilitas Sekolah</h1>
                </div>
                <nav aria-label="Navigasi utama" class="flex flex-wrap gap-3 text-sm font-medium">
                    <a href="#form-laporan" class="rounded-full border border-white/30 bg-white/10 px-4 py-2 hover:bg-white/20 transition">Buat Laporan</a>
                    <a href="#daftar-laporan" class="rounded-full border border-white/30 bg-white/10 px-4 py-2 hover:bg-white/20 transition">Daftar Laporan</a>
                </nav>
            </div>
            <p class="mt-5 max-w-2xl text-blue-100 text-sm md:text-base">Catat dan pantau laporan kerusakan fasilitas sekolah agar penanganan dapat dilakukan lebih cepat dan terorganisir.</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8 md:px-8">

        <section id="form-laporan" aria-labelledby="judul-form" class="mb-8">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200/50 md:p-8">
                <div class="mb-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Form Pelaporan</p>
                    <h2 id="judul-form" class="mt-2 text-2xl font-bold text-slate-800">Laporkan kerusakan fasilitas</h2>
                    <p class="mt-2 text-slate-600">Lengkapi data berikut untuk membantu tim maintenance menindaklanjuti kerusakan dengan cepat.</p>
                </div>

                <form action="" method="post" class="space-y-5">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="space-y-2">
                            <label for="nama_pelapor" class="block text-sm font-medium text-slate-700">Nama pelapor</label>
                            <input class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" type="text" id="nama_pelapor" name="nama_pelapor" maxlength="100" required>
                        </div>

                        <div class="space-y-2">
                            <label for="nama_fasilitas" class="block text-sm font-medium text-slate-700">Nama fasilitas</label>
                            <input class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" type="text" id="nama_fasilitas" name="nama_fasilitas" maxlength="100" required>
                        </div>

                        <div class="space-y-2">
                            <label for="lokasi" class="block text-sm font-medium text-slate-700">Lokasi kerusakan</label>
                            <input class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" type="text" id="lokasi" name="lokasi" maxlength="100" required>
                        </div>

                        <div class="space-y-2">
                            <label for="id_kategori" class="block text-sm font-medium text-slate-700">Kategori fasilitas</label>
                            <select id="id_kategori" name="id_kategori" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                                <option value="">-- Pilih kategori --</option>
                                <option value="1">Elektronik</option>
                                <option value="2">Furnitur</option>
                                <option value="3">Jaringan</option>
                                <option value="4">Peralatan Kelas</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="deskripsi" class="block text-sm font-medium text-slate-700">Deskripsi kerusakan</label>
                        <textarea id="deskripsi" name="deskripsi" rows="5" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required></textarea>
                    </div>

                    <div class="space-y-2 max-w-md">
                        <label for="prioritas" class="block text-sm font-medium text-slate-700">Prioritas</label>
                        <select id="prioritas" name="prioritas" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" required>
                            <option value="">-- Pilih prioritas --</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>

                    <div class="pt-2">
                        <button type="submit" name="submit" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-md shadow-blue-200 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </section>

        <section id="daftar-laporan" aria-labelledby="judul-daftar" class="mb-10">
            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-lg shadow-slate-200/50 md:p-6">
                <div class="mb-5 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600">Daftar Laporan</p>
                        <h2 id="judul-daftar" class="mt-2 text-2xl font-bold text-slate-800">Riwayat kerusakan fasilitas</h2>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-2xl border border-slate-200">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-slate-100 text-slate-700">
                            <tr>
                                <th scope="col" class="px-4 py-3 font-semibold">No.</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Fasilitas</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Kategori</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Lokasi</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Pelapor</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Prioritas</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Status</th>
                                <th scope="col" class="px-4 py-3 font-semibold">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <?php if (!empty($laporan)): ?>
                                <?php foreach ($laporan as $index => $row): ?>
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-3 text-slate-600"><?php echo $index + 1; ?></td>
                                        <td class="px-4 py-3 font-medium text-slate-800"><?php echo htmlspecialchars($row['nama_fasilitas']); ?></td>
                                        <td class="px-4 py-3 text-slate-600"><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                                        <td class="px-4 py-3 text-slate-600"><?php echo htmlspecialchars($row['lokasi']); ?></td>
                                        <td class="px-4 py-3 text-slate-600"><?php echo htmlspecialchars($row['nama_pelapor']); ?></td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold <?php echo badgePrioritas($row['prioritas'] ?? ''); ?>"><?php echo htmlspecialchars($row['prioritas']); ?></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold <?php echo badgeStatus($row['status'] ?? ''); ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                                        </td>
                                        <td class="px-4 py-3 text-slate-600"><?php echo htmlspecialchars(date('d-m-Y', strtotime($row['tanggal_laporan']))); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-slate-500">Belum ada laporan yang tercatat.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-white/70">
        <div class="max-w-7xl mx-auto px-4 py-5 text-center text-sm text-slate-500 md:px-8">
            &copy; 2024 Sistem Pelaporan Kerusakan Fasilitas Sekolah.
        </div>
    </footer>
</body>
</html>
