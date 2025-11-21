<!DOCTYPE html>
<html>
<head>
    <title>Master Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body{background:#f8f9fa;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif}
        .card{border:none;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);transition:all 0.3s ease}
        .card:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(0,0,0,0.12)}
        .icon-circle{width:60px;height:60px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:24px}
        .btn-action{border-radius:12px;font-weight:600;padding:12px 24px;border:none;transition:all 0.3s ease}
        .btn-action:hover{transform:translateY(-1px)}
        .badge-custom{border-radius:8px;padding:6px 12px;font-weight:500}
        .list-item{padding:12px 0;border-bottom:1px solid #f0f0f0}
        .list-item:last-child{border-bottom:none}
        .quick-action{border-radius:16px;padding:24px;text-align:center;border:none;transition:all 0.3s ease;color:white;font-weight:600}
        .quick-action:hover{transform:translateY(-2px);color:white}
    </style>
</head>
<body>
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold text-dark">Master Data PPDB</h2>
        <a href="{{ route('admin-panitia.dashboard') }}" class="btn btn-light border-0 shadow-sm px-4 py-2" style="border-radius:12px;transition:all 0.3s ease" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
            <i class="fas fa-arrow-left me-2 text-muted"></i><span class="fw-semibold text-dark">Kembali</span>
        </a>
    </div>
    @if(session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-primary text-white me-3"><i class="fas fa-graduation-cap"></i></div>
                        <div><h5 class="mb-1 fw-bold">Jurusan</h5><p class="text-muted mb-0 small">Kelola program keahlian yang tersedia</p></div>
                    </div>
                    @foreach($jurusan as $j)
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <div><span class="fw-semibold">{{ $j->nama }}</span><br><span class="badge badge-custom {{ $j->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $j->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="editJurusan({{ $j->id }},'{{ $j->kode }}','{{ $j->nama }}','{{ $j->deskripsi }}',{{ $j->kuota }},{{ $j->is_active ? 'true' : 'false' }})"><i class="fas fa-edit"></i></button>
                        </div>
                    </div>
                    @endforeach
                    <button class="btn btn-primary btn-action w-100 mt-4" data-bs-toggle="modal" data-bs-target="#jurusanModal"><i class="fas fa-edit me-2"></i>Kelola Jurusan</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-success text-white me-3"><i class="fas fa-users"></i></div>
                        <div><h5 class="mb-1 fw-bold">Kuota</h5><p class="text-muted mb-0 small">Atur kuota penerimaan per jurusan</p></div>
                    </div>
                    @foreach($jurusan as $j)
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">{{ $j->nama }}</span><span class="badge badge-custom bg-info">{{ $j->kuota }} siswa</span>
                    </div>
                    @endforeach
                    <button class="btn btn-success btn-action w-100 mt-4" data-bs-toggle="modal" data-bs-target="#kuotaModal"><i class="fas fa-cog me-2"></i>Atur Kuota</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle text-white me-3" style="background:#6f42c1"><i class="fas fa-calendar"></i></div>
                        <div><h5 class="mb-1 fw-bold">Gelombang</h5><p class="text-muted mb-0 small">Kelola periode pendaftaran</p></div>
                    </div>
                    @foreach($gelombang as $g)
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <div><span class="fw-semibold">{{ $g->nama }}</span><br><span class="badge badge-custom {{ $g->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $g->is_active ? 'Aktif' : 'Belum Aktif' }}</span></div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="editGelombang({{ $g->id }},'{{ $g->nama }}','{{ $g->tanggal_mulai }}','{{ $g->tanggal_selesai }}',{{ $g->biaya_pendaftaran }},{{ $g->is_active ? 'true' : 'false' }})"><i class="fas fa-edit"></i></button>
                        </div>
                    </div>
                    @endforeach
                    <button class="btn btn-action w-100 mt-4" style="background:#6f42c1;color:white" data-bs-toggle="modal" data-bs-target="#gelombangModal"><i class="fas fa-edit me-2"></i>Kelola Gelombang</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle text-white me-3" style="background:#f39c12"><i class="fas fa-money-bill"></i></div>
                        <div><h5 class="mb-1 fw-bold">Biaya Daftar</h5><p class="text-muted mb-0 small">Atur biaya pendaftaran</p></div>
                    </div>
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Biaya Pendaftaran</span><span class="badge badge-custom" style="background:#f39c12;color:white">Rp 150.000</span>
                    </div>
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Biaya Daftar Ulang</span><span class="badge badge-custom" style="background:#f39c12;color:white">Rp 500.000</span>
                    </div>
                    <button class="btn btn-action w-100 mt-4" style="background:#f39c12;color:white" data-bs-toggle="modal" data-bs-target="#biayaModal"><i class="fas fa-edit me-2"></i>Atur Biaya</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-danger text-white me-3"><i class="fas fa-file-alt"></i></div>
                        <div><h5 class="mb-1 fw-bold">Syarat Berkas</h5><p class="text-muted mb-0 small">Kelola dokumen yang diperlukan</p></div>
                    </div>
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Ijazah SMP</span><span class="badge badge-custom bg-danger">Wajib</span>
                    </div>
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Kartu Keluarga</span><span class="badge badge-custom bg-danger">Wajib</span>
                    </div>
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Pas Foto</span><span class="badge badge-custom bg-danger">Wajib</span>
                    </div>
                    <button class="btn btn-danger btn-action w-100 mt-4" data-bs-toggle="modal" data-bs-target="#dokumenModal"><i class="fas fa-edit me-2"></i>Kelola Syarat</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle text-white me-3" style="background:#5b6ec7"><i class="fas fa-map-marker-alt"></i></div>
                        <div><h5 class="mb-1 fw-bold">Wilayah</h5><p class="text-muted mb-0 small">Kelola data wilayah dan kode pos</p></div>
                    </div>
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Cileunyi</span><span class="badge badge-custom" style="background:#5b6ec7;color:white">40391</span>
                    </div>
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Bandung Kota</span><span class="badge badge-custom" style="background:#5b6ec7;color:white">40115</span>
                    </div>
                    <div class="list-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Bandung Barat</span><span class="badge badge-custom" style="background:#5b6ec7;color:white">40371</span>
                    </div>
                    <button class="btn btn-action w-100 mt-4" style="background:#5b6ec7;color:white" data-bs-toggle="modal" data-bs-target="#wilayahModal"><i class="fas fa-edit me-2"></i>Kelola Wilayah</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-4 fw-bold">Aksi Cepat</h4>
            <div class="row g-4">
                <div class="col-md-3">
                    <form method="POST" action="{{ route('admin-panitia.sync-data') }}">@csrf
                        <button type="submit" class="btn quick-action w-100 bg-primary">
                            <i class="fas fa-sync-alt fa-2x mb-3 d-block"></i>
                            <div class="fw-bold">Sinkronisasi Data</div>
                        </button>
                    </form>
                </div>
                <div class="col-md-3">
                    <form method="POST" action="{{ route('admin-panitia.backup-data') }}">@csrf
                        <button type="submit" class="btn quick-action w-100 bg-success">
                            <i class="fas fa-download fa-2x mb-3 d-block"></i>
                            <div class="fw-bold">Backup Data</div>
                        </button>
                    </form>
                </div>
                <div class="col-md-3">
                    <button class="btn quick-action w-100" style="background:#6f42c1" data-bs-toggle="modal" data-bs-target="#infoPpdbModal">
                        <i class="fas fa-info-circle fa-2x mb-3 d-block"></i>
                        <div class="fw-bold">Info PPDB</div>
                    </button>
                </div>
                <div class="col-md-3">
                    <form method="POST" action="{{ route('admin-panitia.clear-cache') }}">@csrf
                        <button type="submit" class="btn quick-action w-100 bg-danger">
                            <i class="fas fa-trash fa-2x mb-3 d-block"></i>
                            <div class="fw-bold">Bersihkan Cache</div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="jurusanModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form id="jurusanForm" method="POST" action="{{ route('admin-panitia.store-jurusan') }}">@csrf<div class="modal-header"><h5 class="modal-title">Kelola Jurusan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="jurusan_method" name="_method"><div class="mb-3"><label class="form-label">Kode</label><input type="text" class="form-control" name="kode" id="jurusan_kode" required></div><div class="mb-3"><label class="form-label">Nama</label><input type="text" class="form-control" name="nama" id="jurusan_nama" required></div><div class="mb-3"><label class="form-label">Deskripsi</label><textarea class="form-control" name="deskripsi" id="jurusan_deskripsi"></textarea></div><div class="mb-3"><label class="form-label">Kuota</label><input type="number" class="form-control" name="kuota" id="jurusan_kuota" min="1" required></div><div class="mb-3 form-check" id="jurusan_active_check" style="display:none"><input type="checkbox" class="form-check-input" name="is_active" id="jurusan_is_active"><label class="form-check-label">Aktif</label></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div></form></div></div></div>

<div class="modal fade" id="kuotaModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Atur Kuota</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@foreach($jurusan as $j)<form method="POST" action="{{ route('admin-panitia.update-jurusan', $j) }}" class="mb-3">@csrf @method('PUT')<input type="hidden" name="kode" value="{{ $j->kode }}"><input type="hidden" name="nama" value="{{ $j->nama }}"><input type="hidden" name="deskripsi" value="{{ $j->deskripsi }}"><div class="row align-items-center"><div class="col-6"><strong>{{ $j->nama }}</strong></div><div class="col-4"><input type="number" class="form-control" name="kuota" value="{{ $j->kuota }}" min="1" required></div><div class="col-2"><button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save"></i></button></div></div></form>@endforeach</div></div></div></div>

<div class="modal fade" id="gelombangModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form id="gelombangForm" method="POST" action="{{ route('admin-panitia.store-gelombang') }}">@csrf<div class="modal-header"><h5 class="modal-title">Kelola Gelombang</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" id="gelombang_method" name="_method"><div class="mb-3"><label class="form-label">Nama</label><input type="text" class="form-control" name="nama" id="gelombang_nama" required></div><div class="mb-3"><label class="form-label">Tanggal Mulai</label><input type="date" class="form-control" name="tanggal_mulai" id="gelombang_tanggal_mulai" required></div><div class="mb-3"><label class="form-label">Tanggal Selesai</label><input type="date" class="form-control" name="tanggal_selesai" id="gelombang_tanggal_selesai" required></div><div class="mb-3"><label class="form-label">Biaya</label><input type="number" class="form-control" name="biaya_pendaftaran" id="gelombang_biaya" min="0" required></div><div class="mb-3 form-check" id="gelombang_active_check" style="display:none"><input type="checkbox" class="form-check-input" name="is_active" id="gelombang_is_active"><label class="form-check-label">Aktif</label></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div></form></div></div></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function editJurusan(id,kode,nama,deskripsi,kuota,isActive){document.getElementById('jurusanForm').action=`/admin-panitia/jurusan/${id}`;document.getElementById('jurusan_method').value='PUT';document.getElementById('jurusan_kode').value=kode;document.getElementById('jurusan_nama').value=nama;document.getElementById('jurusan_deskripsi').value=deskripsi;document.getElementById('jurusan_kuota').value=kuota;document.getElementById('jurusan_is_active').checked=isActive==='true';document.getElementById('jurusan_active_check').style.display='block';new bootstrap.Modal(document.getElementById('jurusanModal')).show()}
function editGelombang(id,nama,tanggalMulai,tanggalSelesai,biaya,isActive){document.getElementById('gelombangForm').action=`/admin-panitia/gelombang/${id}`;document.getElementById('gelombang_method').value='PUT';document.getElementById('gelombang_nama').value=nama;document.getElementById('gelombang_tanggal_mulai').value=tanggalMulai;document.getElementById('gelombang_tanggal_selesai').value=tanggalSelesai;document.getElementById('gelombang_biaya').value=biaya;document.getElementById('gelombang_is_active').checked=isActive==='true';document.getElementById('gelombang_active_check').style.display='block';new bootstrap.Modal(document.getElementById('gelombangModal')).show()}
document.getElementById('jurusanModal').addEventListener('hidden.bs.modal',function(){document.getElementById('jurusanForm').action='{{ route("admin-panitia.store-jurusan") }}';document.getElementById('jurusan_method').value='';document.getElementById('jurusanForm').reset();document.getElementById('jurusan_active_check').style.display='none'})
document.getElementById('gelombangModal').addEventListener('hidden.bs.modal',function(){document.getElementById('gelombangForm').action='{{ route("admin-panitia.store-gelombang") }}';document.getElementById('gelombang_method').value='';document.getElementById('gelombangForm').reset();document.getElementById('gelombang_active_check').style.display='none'})
</script>
<div class="modal fade" id="biayaModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST" action="{{ route('admin-panitia.store-pembayaran') }}">@csrf<div class="modal-header"><h5 class="modal-title">Atur Biaya</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label class="form-label">Nama Biaya</label><input type="text" class="form-control" name="nama" required></div><div class="mb-3"><label class="form-label">Nominal</label><input type="number" class="form-control" name="nominal" min="0" required></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div></form></div></div></div>

<div class="modal fade" id="dokumenModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST" action="{{ route('admin-panitia.store-dokumen') }}">@csrf<div class="modal-header"><h5 class="modal-title">Kelola Syarat Berkas</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label class="form-label">Nama Dokumen</label><input type="text" class="form-control" name="nama" required></div><div class="mb-3 form-check"><input type="checkbox" class="form-check-input" name="is_required" checked><label class="form-check-label">Wajib</label></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Simpan</button></div></form></div></div></div>

<div class="modal fade" id="wilayahModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form method="POST" action="{{ route('admin-panitia.store-provinsi') }}">@csrf<div class="modal-header"><h5 class="modal-title">Kelola Wilayah</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label class="form-label">Nama Wilayah</label><input type="text" class="form-control" name="nama" required></div><div class="mb-3"><label class="form-label">Kode Pos</label><input type="text" class="form-control" name="kode" required></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div></form></div></div></div>

<div class="modal fade" id="infoPpdbModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><form method="POST" action="{{ route('admin-panitia.update-info-ppdb') }}">@csrf<div class="modal-header"><h5 class="modal-title">Informasi PPDB</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="row"><div class="col-md-6 mb-3"><label class="form-label">Nama Sekolah</label><input type="text" class="form-control" name="nama_sekolah" value="{{ $infoPpdb['nama_sekolah'] }}" required></div><div class="col-md-6 mb-3"><label class="form-label">Tahun Ajaran</label><input type="text" class="form-control" name="tahun_ajaran" value="{{ $infoPpdb['tahun_ajaran'] }}" required></div><div class="col-12 mb-3"><label class="form-label">Alamat Sekolah</label><textarea class="form-control" name="alamat_sekolah" rows="2" required>{{ $infoPpdb['alamat_sekolah'] }}</textarea></div><div class="col-md-6 mb-3"><label class="form-label">Telepon</label><input type="text" class="form-control" name="telepon_sekolah" value="{{ $infoPpdb['telepon_sekolah'] }}" required></div><div class="col-md-6 mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="email_sekolah" value="{{ $infoPpdb['email_sekolah'] }}" required></div><div class="col-12 mb-3"><label class="form-label">Kepala Sekolah</label><input type="text" class="form-control" name="kepala_sekolah" value="{{ $infoPpdb['kepala_sekolah'] }}" required></div></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div></form></div></div></div>

</body>
</html>