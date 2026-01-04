<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil UMKM - KUMPARAN</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #eef2ff 0%, #f8fafc 100%) !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }

        .form-section {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
            border: 1px solid #eef2f7;
        }

        .form-section h2 {
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #0f172a;
        }

        .section-title {
            color: #1e40af;
            font-weight: 800;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 14px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            font-size: 1.05rem;
        }

        .section-title i {
            margin-right: 12px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            padding: 10px;
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid #dbe1ea;
            padding: 13px 16px;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
            border-color: #2563eb;
        }

        .produk-item {
            border: 1px dashed #c7d2fe;
            border-radius: 18px;
            background: #f8fafc;
            position: relative;
            transition: 0.3s ease;
        }

        .produk-item:hover {
            background: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.12);
        }

        .remove-produk {
            position: absolute;
            top: -12px;
            right: -12px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            padding: 14px;
        }

        .btn-add {
            border-radius: 999px;
            font-weight: 700;
            padding: 8px 20px;
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-section p-4 p-md-5">
                
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Lengkapi Profil UMKM</h2>
                    <p class="text-muted">Isi detail usaha Anda untuk mempermudah akses modal dan pemasaran.</p>
                </div>

                <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <h5 class="section-title"><i class="fas fa-id-card"></i> 1. Identitas Pemilik & Profil Dasar</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Usaha</label>
                                <input type="text" name="nama_usaha" class="form-control" placeholder="Contoh: Keripik Barokah" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted fw-bold">+62</span>
                                    <input type="number" name="no_whatsapp" class="form-control" placeholder="8123456789">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5 class="section-title"><i class="fas fa-map-marker-alt"></i> 2. Legalitas & Lokasi Usaha</h5>
                        <div class="mb-4">
                            <label class="form-label">Alamat Lengkap Usaha</label>
                            <textarea name="alamat_usaha" class="form-control" rows="3" placeholder="Jl. Merdeka No. 123..."></textarea>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label">Status Tempat</label>
                                <select name="status_tempat" class="form-select">
                                    <option value="Milik Sendiri">Milik Sendiri</option>
                                    <option value="Sewa">Sewa</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Luas Lahan (m2)</label>
                                <input type="number" name="luas_lahan" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">KBLI (5 Digit)</label>
                                <input type="text" name="kbli" maxlength="5" class="form-control" placeholder="47111">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">NPWP (Opsional)</label>
                                <input type="text" name="npwp" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5 class="section-title"><i class="fas fa-coins"></i> 3. Detail Operasional & Keuangan</h5>
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Kapasitas Produksi</label>
                                <input type="text" name="kapasitas_produksi" class="form-control" placeholder="100kg/bulan">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Modal Usaha (Rp)</label>
                                <input type="number" name="modal_usaha" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Omzet Tahunan (Rp)</label>
                                <input type="number" name="omzet_tahunan" class="form-control">
                            </div>
                        </div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Sistem Penjualan</label>
                                <select name="sistem_penjualan" class="form-select">
                                    <option value="luring">Offline</option>
                                    <option value="daring">Online</option>
                                    <option value="keduanya">Keduanya</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nama Bank</label>
                                <select name="nama_bank" class="form-select">
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nomor Rekening</label>
                                <input type="number" name="nomor_rekening" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Deskripsi Singkat Usaha</label>
                            <textarea name="deskripsi" class="form-control" rows="3" required placeholder="Ceritakan singkat tentang keunggulan produk Anda..."></textarea>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="section-title mb-0" style="border:none; padding:0;"><i class="fas fa-images"></i> 4. Portofolio Produk</h5>
                            <button type="button" id="add-produk" class="btn btn-success btn-add btn-sm shadow-sm">
                                <i class="fas fa-plus me-1"></i> Tambah Produk
                            </button>
                        </div>
                        
                        <div id="produk-wrapper" class="row g-3">
                            <div class="col-12 produk-item p-3 mb-3 shadow-sm">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="small fw-bold text-muted">Nama Produk</label>
                                        <input type="text" name="produk_nama[]" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small fw-bold text-muted">Detail/Ukuran</label>
                                        <input type="text" name="produk_detail[]" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small fw-bold text-muted">Foto Produk</label>
                                        <input type="file" name="produk_foto[]" class="form-control form-control-sm" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-3 pt-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill shadow">
                            Daftarkan Usaha Sekarang <i class="fas fa-arrow-right"></i>
                        </button>
                        <a href="{{ route('umkm.dashboard') }}" class="btn btn-link text-muted text-decoration-none text-center">
                            Batal dan Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('add-produk').addEventListener('click', function() {
        const wrapper = document.getElementById('produk-wrapper');
        const div = document.createElement('div');
        div.className = 'col-12 produk-item p-3 mb-3 shadow-sm animate-fade-in';
        div.innerHTML = `
            <button type="button" class="btn btn-danger remove-produk shadow-sm">✕</button>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="small fw-bold text-muted">Nama Produk</label>
                    <input type="text" name="produk_nama[]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold text-muted">Detail/Ukuran</label>
                    <input type="text" name="produk_detail[]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold text-muted">Foto Produk</label>
                    <input type="file" name="produk_foto[]" class="form-control form-control-sm" accept="image/*">
                </div>
            </div>
        `;
        wrapper.appendChild(div);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-produk')) {
            e.target.closest('.produk-item').remove();
        }
    });
</script>
</body>
</html>