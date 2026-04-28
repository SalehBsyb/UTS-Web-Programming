<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #edf2f7; color: #2f3e4d; }
        header { background-color: #2a3d55; color: white; padding: 22px 30px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        header .brand { display: flex; align-items: center; gap: 12px; }
        header h1 { margin: 0; font-size: 22px; letter-spacing: 0.02em; }
        header p { margin: 2px 0 0 0; font-size: 13px; color: rgba(255,255,255,0.75); }
        .container { display: flex; gap: 24px; min-height: calc(100vh - 86px); padding: 24px 30px 30px; }
        .sidebar { width: 260px; background-color: #ffffff; border-radius: 18px; box-shadow: 0 10px 30px rgba(42,61,85,0.08); padding: 24px; }
        .sidebar h3 { font-size: 12px; color: #6d7d8f; letter-spacing: 1px; text-transform: uppercase; margin: 0 0 20px; }
        .menu-item { display: flex; align-items: center; gap: 10px; padding: 14px 18px; cursor: pointer; color: #374151; transition: background-color 0.2s, color 0.2s; border-radius: 12px; margin-bottom: 8px; }
        .menu-item:hover { background-color: #f4f7fb; }
        .menu-item.active { background-color: #e7f3ff; color: #1e5fb8; font-weight: 700; }
        .content { flex: 1; }
        .page-card { background-color: #ffffff; border-radius: 22px; box-shadow: 0 18px 40px rgba(38,63,97,0.08); padding: 28px; min-height: 520px; }
        .card-header { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 24px; }
        .card-header h2 { margin: 0; font-size: 24px; letter-spacing: 0.01em; }
        .card-header p { margin: 4px 0 0; color: #637381; font-size: 14px; }
        .badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 999px; background-color: #eef7ff; color: #1763b3; font-size: 12px; font-weight: 700; }
        .form-grid { display: grid; gap: 16px; }
        .form-grid.two-cols { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .form-note { color: #6c7a8a; font-size: 13px; margin-top: 6px; }
        .confirm-overlay { display: none; position: fixed; inset: 0; background: rgba(23,40,60,0.38); backdrop-filter: blur(3px); justify-content: center; align-items: center; z-index: 1100; padding: 20px; }
        .confirm-overlay.active { display: flex; }
        .confirm-card { width: 420px; max-width: 100%; background: #ffffff; border-radius: 24px; padding: 28px; text-align: center; box-shadow: 0 24px 60px rgba(34,54,84,0.16); }
        .confirm-card h3 { margin: 0 0 12px; font-size: 22px; color: #1f3251; }
        .confirm-card p { color: #6a7a90; line-height: 1.7; margin-bottom: 24px; }
        .confirm-icon { width: 62px; height: 62px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; background: #fdecec; color: #d64545; margin-bottom: 18px; font-size: 28px; }
        .confirm-actions { display: flex; justify-content: center; gap: 12px; }
        .btn-secondary { background-color: #7b8c9d; color: white; padding: 12px 20px; border: none; border-radius: 14px; cursor: pointer; }
        .btn-secondary:hover { background-color: #657387; }
        .btn-danger { background-color: #d64545; color: white; padding: 12px 20px; border: none; border-radius: 14px; cursor: pointer; }
        .btn-danger:hover { background-color: #b13238; }
        .input-file-wrapper { display: flex; align-items: center; gap: 12px; }
        .input-file-wrapper input[type=file] { flex: 1; }
        .btn-tambah { background-color: #11a885; color: white; padding: 12px 22px; border: none; border-radius: 999px; cursor: pointer; font-weight: 600; box-shadow: 0 10px 20px rgba(17,168,133,0.18); transition: transform 0.2s, background-color 0.2s; }
        .btn-tambah:hover { background-color: #0e8a71; transform: translateY(-1px); }
        .btn-edit, .btn-hapus { border: none; border-radius: 8px; padding: 8px 14px; cursor: pointer; font-weight: 600; transition: transform 0.15s; }
        .btn-edit { background-color: #2f78d8; color: white; }
        .btn-hapus { background-color: #e74c3c; color: white; }
        .btn-edit:hover, .btn-hapus:hover { transform: translateY(-1px); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(31,56,96,0.06); }
        th, td { padding: 16px 18px; text-align: left; border-bottom: 1px solid #eef1f6; }
        th { background-color: #f8fafc; color: #4d5766; font-size: 14px; text-transform: uppercase; letter-spacing: 0.04em; }
        tr:nth-child(even) { background-color: #fcfdff; }
        tr:hover td { background-color: #f2f6fb; }
        .empty { text-align: center; color: #7a8b9a; padding: 45px 0; font-size: 15px; }
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.45); justify-content: center; align-items: center; z-index: 1000; padding: 20px; }
        .modal-overlay.active { display: flex; }
        .modal { background: white; padding: 28px; border-radius: 24px; width: 520px; max-width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 26px 60px rgba(43,72,106,0.16); }
        .modal h3 { margin-top: 0; color: #1f3251; font-size: 22px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 700; color: #3f4d64; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px 14px; border: 1px solid #d8dee7; border-radius: 14px; font-family: inherit; font-size: 14px; color: #1f2f43; background-color: #fdfefe; }
        .form-group textarea { min-height: 120px; resize: vertical; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; }
        .btn-batal { background-color: #607d98; color: white; padding: 12px 20px; border: none; border-radius: 14px; cursor: pointer; }
        .btn-simpan { background-color: #11a885; color: white; padding: 12px 20px; border: none; border-radius: 14px; cursor: pointer; }
        .img-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 14px; }
        .alert { padding: 14px 16px; border-radius: 14px; margin-bottom: 18px; }
        .alert-success { background-color: #eaf7f1; color: #1a6d52; border: 1px solid #c7eee0; }
        .alert-error { background-color: #fde2e6; color: #952837; border: 1px solid #f5c1c7; }
    </style>
</head>
<body>

    <header>
        <div class="brand">
            <div>
                <h1>Sistem Manajemen Blog (CMS)</h1>
            </div>
        </div>
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

    <!-- Modal Form -->
    <div class="modal-overlay" id="modal-overlay">
        <div class="modal" id="modal-content">
            <!-- Form akan diisi dinamis -->
        </div>
    </div>

    <div class="confirm-overlay" id="confirm-overlay">
        <div class="confirm-card">
            <div class="confirm-icon">!</div>
            <h3>Hapus data ini?</h3>
            <p>Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="confirm-actions">
                <button class="btn-secondary" onclick="closeConfirm()">Batal</button>
                <button class="btn-danger" onclick="confirmDelete()">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        let currentMenu = 'penulis';

        document.addEventListener('DOMContentLoaded', () => {
            loadMenu('penulis', document.querySelector('.menu-item.active'));
        });

        function loadMenu(menu, element) {
            document.querySelectorAll('.menu-item').forEach(el => el.classList.remove('active'));
            if(element) element.classList.add('active');
            currentMenu = menu;

            const contentDiv = document.getElementById('main-content');
            contentDiv.innerHTML = `<div class="page-card"><div class="card-header"><div><h2>Data ${menu.charAt(0).toUpperCase() + menu.slice(1)}</h2><p>Kelola daftar ${menu} dengan cepat dan mudah.</p></div><button class="btn-tambah" onclick="openForm('${menu}')">+ Tambah ${menu.charAt(0).toUpperCase() + menu.slice(1)}</button></div><p>Memuat data ${menu}...</p></div>`;

            fetch(`ambil_${menu}.php`)
                .then(response => {
                    if (!response.ok) throw new Error("Gagal mengambil data dari server");
                    return response.text();
                })
                .then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (err) {
                        throw new Error(`Server tidak mengembalikan JSON valid:\n${text}`);
                    }
                })
                .then(data => {
                    renderTable(menu, data, contentDiv);
                })
                .catch(error => {
                    contentDiv.innerHTML = `<div class="alert alert-error">Error: ${error.message}</div>`;
                });
        }

        function renderTable(menu, data, container) {
            let html = `<div class="page-card"><div class="card-header"><div><h2>Data ${menu.charAt(0).toUpperCase() + menu.slice(1)}</h2><p>Kelola daftar ${menu} secara terstruktur.</p></div><button class="btn-tambah" onclick="openForm('${menu}')">+ Tambah ${menu.charAt(0).toUpperCase() + menu.slice(1)}</button></div>`;

            if (!Array.isArray(data) || data.length === 0) {
                html += `<div class="empty"><p>Belum ada data ${menu}.</p></div>`;
                container.innerHTML = html;
                return;
            }

            html += `<table><thead><tr>`;
            
            if (menu === 'penulis') {
                html += `<th>Foto</th><th>Nama</th><th>Username</th><th>Password</th><th>Aksi</th>`;
            } else if (menu === 'artikel') {
                html += `<th>Gambar</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th>`;
            } else if (menu === 'kategori') {
                html += `<th>Nama Kategori</th><th>Keterangan</th><th>Aksi</th>`;
            }
            
            html += `</tr></thead><tbody>`;

            data.forEach(row => {
                html += `<tr>`;
                if (menu === 'penulis') {
                    html += `<td><img src="${row.foto || 'uploads_penulis/default.png'}" class="img-thumb" onerror="this.src='uploads_penulis/default.png'"></td>`;
                    html += `<td>${(row.nama_depan || '-') + ' ' + (row.nama_belakang || '')}</td>`;
                    html += `<td>${row.user_name || '-'}</td>`;
                    html += `<td>••••••••••</td>`;
                } else if (menu === 'artikel') {
                    html += `<td><img src="uploads_artikel/${row.gambar || ''}" class="img-thumb" onerror="this.src='uploads_artikel/default.png'"></td>`;
                    html += `<td>${row.judul || '-'}</td>`;
                    html += `<td><span class="badge">${row.nama_kategori || '-'}</span></td>`;
                    html += `<td>${(row.nama_depan || '') + ' ' + (row.nama_belakang || '')}</td>`;
                    html += `<td>${row.hari_tanggal || '-'}</td>`;
                } else if (menu === 'kategori') {
                    html += `<td>${row.nama_kategori || '-'}</td>`;
                    html += `<td>${row.keterangan || '-'}</td>`;
                }
                html += `<td>
                    <button class="btn-edit" onclick="editData('${menu}', ${row.id})">Edit</button>
                    <button class="btn-hapus" onclick="hapusData('${menu}', ${row.id})">Hapus</button>
                </td>`;
                html += `</tr>`;
            });

            html += `</tbody></table>`;
            container.innerHTML = html;
        }

        let pendingDelete = null;

        function hapusData(menu, id) {
            pendingDelete = { menu, id };
            document.getElementById('confirm-overlay').classList.add('active');
        }

        function closeConfirm() {
            pendingDelete = null;
            document.getElementById('confirm-overlay').classList.remove('active');
        }

        function confirmDelete() {
            if (!pendingDelete) return;
            const { menu, id } = pendingDelete;
            fetch(`hapus_${menu}.php?id=${id}`, { method: 'GET' })
                .then(response => response.text())
                .then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (err) {
                        throw new Error(`Server tidak mengembalikan JSON valid:\n${text}`);
                    }
                })
                .then(data => {
                    if (data.status === 'success') {
                        loadMenu(menu, document.querySelector('.menu-item.active'));
                    } else {
                        alert(data.message || "Gagal menghapus data");
                    }
                })
                .catch(err => alert("Error: " + err.message))
                .finally(() => closeConfirm());
        }

        function openForm(menu, id = null) {
            const overlay = document.getElementById('modal-overlay');
            const modal = document.getElementById('modal-content');
            const isEdit = id !== null;
            const title = isEdit ? 'Edit' : 'Tambah';
            
            let formHtml = `<h3>${title} ${menu.charAt(0).toUpperCase() + menu.slice(1)}</h3>
                <form id="form-data" onsubmit="return saveData(event, '${menu}', ${id || 'null'})">`;

            if (menu === 'penulis') {
                formHtml += `
                    <div class="form-grid two-cols">
                        <div class="form-group"><label>Nama Depan</label><input type="text" name="nama_depan" id="f_nama_depan" required></div>
                        <div class="form-group"><label>Nama Belakang</label><input type="text" name="nama_belakang" id="f_nama_belakang" required></div>
                    </div>
                    <div class="form-grid two-cols">
                        <div class="form-group"><label>Username</label><input type="text" name="user_name" id="f_user_name" required></div>
                        <div class="form-group"><label>${!isEdit ? 'Password' : 'Password Baru (kosongkan jika tidak diganti)'}</label><input type="password" name="password" id="f_password" ${!isEdit ? 'required' : ''}></div>
                    </div>
                    <div class="form-group"><label>Foto Profil</label><div class="input-file-wrapper"><input type="file" name="foto" id="f_foto" ${!isEdit ? 'required' : ''} accept="image/*"></div></div>
                `;
            } else if (menu === 'kategori') {
                formHtml += `
                    <div class="form-group"><label>Nama Kategori</label><input type="text" name="nama_kategori" id="f_nama_kategori" required></div>
                    <div class="form-group"><label>Keterangan</label><textarea name="keterangan" id="f_keterangan" required></textarea></div>
                `;
            } else if (menu === 'artikel') {
                formHtml += `
                    <div class="form-group"><label>Judul</label><input type="text" name="judul" id="f_judul" required></div>
                    <div class="form-grid two-cols">
                        <div class="form-group"><label>Penulis</label><select name="id_penulis" id="f_id_penulis" required><option value="">Loading...</option></select></div>
                        <div class="form-group"><label>Kategori</label><select name="id_kategori" id="f_id_kategori" required><option value="">Loading...</option></select></div>
                    </div>
                    <div class="form-group"><label>Isi Artikel</label><textarea name="isi" id="f_isi" required></textarea></div>
                    <div class="form-grid two-cols">
                        <div class="form-group"><label>Hari / Tanggal</label><input type="text" name="hari_tanggal" id="f_hari_tanggal" placeholder="Senin, 28 April 2025" required></div>
                        <div class="form-group"><label>Gambar</label><input type="file" name="gambar" id="f_gambar" ${!isEdit ? 'required' : ''} accept="image/*"></div>
                    </div>
                `;
            }

            formHtml += `
                <div class="modal-actions">
                    <button type="button" class="btn-batal" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-simpan">${isEdit ? 'Simpan Perubahan' : 'Simpan Data'}</button>
                </div>
            </form>`;

            modal.innerHTML = formHtml;
            overlay.classList.add('active');

            if (menu === 'artikel') {
                loadSelectOptions();
            }

            if (isEdit) {
                fetch(`ambil_satu_${menu}.php?id=${id}`)
                    .then(r => r.json())
                    .then(data => {
                        if (menu === 'penulis') {
                            document.getElementById('f_nama_depan').value = data.nama_depan || '';
                            document.getElementById('f_nama_belakang').value = data.nama_belakang || '';
                            document.getElementById('f_user_name').value = data.user_name || '';
                        } else if (menu === 'kategori') {
                            document.getElementById('f_nama_kategori').value = data.nama_kategori || '';
                            document.getElementById('f_keterangan').value = data.keterangan || '';
                        } else if (menu === 'artikel') {
                            document.getElementById('f_judul').value = data.judul || '';
                            document.getElementById('f_isi').value = data.isi || '';
                            document.getElementById('f_hari_tanggal').value = data.hari_tanggal || '';
                            if (data.id_kategori) document.getElementById('f_id_kategori').value = data.id_kategori;
                            if (data.id_penulis) document.getElementById('f_id_penulis').value = data.id_penulis;
                        }
                    });
            }
        }

        function loadSelectOptions() {
            fetch('ambil_kategori.php')
                .then(r => r.json())
                .then(data => {
                    const sel = document.getElementById('f_id_kategori');
                    sel.innerHTML = '<option value="">Pilih Kategori</option>' + 
                        data.map(d => `<option value="${d.id}">${d.nama_kategori}</option>`).join('');
                });
            fetch('ambil_penulis.php')
                .then(r => r.json())
                .then(data => {
                    const sel = document.getElementById('f_id_penulis');
                    sel.innerHTML = '<option value="">Pilih Penulis</option>' + 
                        data.map(d => `<option value="${d.id}">${d.nama_depan} ${d.nama_belakang}</option>`).join('');
                });
        }

        function closeModal() {
            document.getElementById('modal-overlay').classList.remove('active');
        }

        function editData(menu, id) {
            openForm(menu, id);
        }

        function saveData(e, menu, id) {
            e.preventDefault();
            const form = document.getElementById('form-data');
            const formData = new FormData(form);
            const url = id ? `update_${menu}.php` : `simpan_${menu}.php`;
            if (id) formData.append('id', id);

            fetch(url, { method: 'POST', body: formData })
                .then(r => r.text())
                .then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (err) {
                        throw new Error(`Server tidak mengembalikan JSON valid:\n${text}`);
                    }
                })
                .then(data => {
                    if (data.status === 'success') {
                        closeModal();
                        loadMenu(menu, document.querySelector('.menu-item.active'));
                    } else {
                        alert(data.message || 'Gagal menyimpan data');
                    }
                })
                .catch(err => alert('Error: ' + err.message));

            return false;
        }
    </script>
</body>
</html>

