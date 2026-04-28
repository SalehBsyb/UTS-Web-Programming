<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f4f6f9; }
        /* Header */
        header { background-color: #34495e; color: white; padding: 15px 30px; display: flex; align-items: center; }
        header h1 { margin: 0; font-size: 22px; }
        header p { margin: 0 0 0 10px; font-size: 14px; color: #bdc3c7; }
        /* Layout */
        .container { display: flex; min-height: calc(100vh - 60px); }
        /* Sidebar */
        .sidebar { width: 250px; background-color: white; border-right: 1px solid #ddd; padding: 20px 0; }
        .sidebar h3 { font-size: 12px; color: #95a5a6; padding-left: 20px; letter-spacing: 1px; }
        .menu-item { padding: 12px 20px; cursor: pointer; color: #2c3e50; transition: 0.2s; border-left: 4px solid transparent; }
        .menu-item:hover { background-color: #f1f2f6; }
        .menu-item.active { background-color: #e8f5e9; border-left-color: #2ecc71; color: #27ae60; font-weight: bold; }
        /* Main Content */
        .content { flex: 1; padding: 30px; }
        /* Komponen Umum (Tombol & Tabel) */
        .btn-tambah { background-color: #2ecc71; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; float: right; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; color: #555; }
    </style>
</head>
<body>

    <header>
        <h1>Sistem Manajemen Blog (CMS)</h1>
        <p>Blog Keren</p>
    </header>

    <div class="container">
        <div class="sidebar">
            <h3>MENU UTAMA</h3>
            <div class="menu-item active" onclick="loadMenu('penulis', this)">👤 Kelola Penulis</div>
            <div class="menu-item" onclick="loadMenu('artikel', this)">📄 Kelola Artikel</div>
            <div class="menu-item" onclick="loadMenu('kategori', this)">📁 Kelola Kategori</div>
        </div>

        <div class="content" id="main-content">
            <h2>Data Penulis</h2>
            <p>Memuat data...</p>
        </div>
    </div>

    <script>
        // Saat halaman pertama kali dimuat, load data penulis
        document.addEventListener('DOMContentLoaded', () => {
            loadMenu('penulis', document.querySelector('.menu-item.active'));
        });

        // Fungsi fetch API untuk memuat data tanpa reload (Asynchronous)
        function loadMenu(menu, element) {
            // Ubah class menu menjadi active
            document.querySelectorAll('.menu-item').forEach(el => el.classList.remove('active'));
            element.classList.add('active');

            const contentDiv = document.getElementById('main-content');
            contentDiv.innerHTML = `<p>Memuat data ${menu}...</p>`;

            // Lakukan Fetch API sesuai nama menu (harus dipasangkan dengan file kodingan kelola Anda)
            // Contoh struktur fetch mengambil file JSON/HTML dari backend:
            fetch(`ambil_${menu}.php`)
                .then(response => {
                    if (!response.ok) throw new Error("Gagal mengambil data dari server");
                    return response.text(); 
                    // Jika backend mereturn HTML gunakan .text()
                    // Jika backend mereturn JSON gunakan .json() lalu render manual
                })
                .then(html => {
                    contentDiv.innerHTML = html;
                })
                .catch(error => {
                    contentDiv.innerHTML = `<p style="color:red;">Error: ${error.message}. <br><small>Pastikan file ambil_${menu}.php sudah dibuat dan ada di folder yang sama.</small></p>`;
                });
        }
        
        // Fungsi tambahan untuk Delete (Contoh Fetch API)
        function hapusData(menu, id) {
            if(confirm("Hapus data ini? Data yang dihapus tidak dapat dikembalikan.")) {
                fetch(`hapus_${menu}.php?id=${id}`, { method: 'GET' })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'success') {
                            // Reload menu yang sedang aktif
                            loadMenu(menu, document.querySelector('.menu-item.active'));
                        } else {
                            alert("Gagal menghapus data");
                        }
                    });
            }
        }
    </script>
</body>
</html>