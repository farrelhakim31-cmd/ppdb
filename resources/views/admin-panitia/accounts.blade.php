@extends('layouts.minimal')

@section('title', 'Kelola Akun - Admin Panitia')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-purple-50">
    <div class="bg-white shadow-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Kelola Akun</h1>
                    <p class="text-slate-600 mt-1">Manajemen User dan Role</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="showAddUserModal()" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Tambah User
                    </button>
                    <a href="{{ route('admin-panitia.dashboard') }}" class="bg-gradient-to-r from-slate-600 to-slate-700 text-white px-6 py-3 rounded-xl hover:from-slate-700 hover:to-slate-800 transition-all duration-200 shadow-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-8">
            @php
                $adminCount = $users->where('role', 'admin')->count();
                $verifikatorCount = $users->where('role', 'verifikator')->count();
                $keuanganCount = $users->where('role', 'keuangan')->count();
                $siswaCount = $users->where('role', 'siswa')->count();
                $kepalaCount = $users->where('role', 'kepala')->count();
                $kepalaSekolahCount = $users->where('role', 'kepala_sekolah')->count();
                $totalUsers = $users->count();
            @endphp

            <div class="bg-white rounded-2xl shadow-lg p-4 border border-slate-100">
                <div class="text-center">
                    <div class="p-2 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg mx-auto w-fit mb-2">
                        <i class="fas fa-users text-white text-sm"></i>
                    </div>
                    <p class="text-xs text-slate-600 font-medium">Total User</p>
                    <p class="text-xl font-bold text-slate-800">{{ $totalUsers }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-4 border border-slate-100">
                <div class="text-center">
                    <div class="p-2 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg mx-auto w-fit mb-2">
                        <i class="fas fa-user-shield text-white text-sm"></i>
                    </div>
                    <p class="text-xs text-slate-600 font-medium">Admin</p>
                    <p class="text-xl font-bold text-slate-800">{{ $adminCount }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-4 border border-slate-100">
                <div class="text-center">
                    <div class="p-2 rounded-xl bg-gradient-to-br from-green-500 to-green-600 shadow-lg mx-auto w-fit mb-2">
                        <i class="fas fa-user-check text-white text-sm"></i>
                    </div>
                    <p class="text-xs text-slate-600 font-medium">Verifikator</p>
                    <p class="text-xl font-bold text-slate-800">{{ $verifikatorCount }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-4 border border-slate-100">
                <div class="text-center">
                    <div class="p-2 rounded-xl bg-gradient-to-br from-yellow-500 to-yellow-600 shadow-lg mx-auto w-fit mb-2">
                        <i class="fas fa-calculator text-white text-sm"></i>
                    </div>
                    <p class="text-xs text-slate-600 font-medium">Keuangan</p>
                    <p class="text-xl font-bold text-slate-800">{{ $keuanganCount }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-4 border border-slate-100">
                <div class="text-center">
                    <div class="p-2 rounded-xl bg-gradient-to-br from-red-500 to-red-600 shadow-lg mx-auto w-fit mb-2">
                        <i class="fas fa-user-graduate text-white text-sm"></i>
                    </div>
                    <p class="text-xs text-slate-600 font-medium">Siswa</p>
                    <p class="text-xl font-bold text-slate-800">{{ $siswaCount }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-4 border border-slate-100">
                <div class="text-center">
                    <div class="p-2 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-lg mx-auto w-fit mb-2">
                        <i class="fas fa-user-tie text-white text-sm"></i>
                    </div>
                    <p class="text-xs text-slate-600 font-medium">Kepala</p>
                    <p class="text-xl font-bold text-slate-800">{{ $kepalaCount + $kepalaSekolahCount }}</p>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100 mb-6">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="md:w-48">
                    <select name="role" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="verifikator" {{ request('role') == 'verifikator' ? 'selected' : '' }}>Verifikator</option>
                        <option value="keuangan" {{ request('role') == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                        <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="kepala" {{ request('role') == 'kepala' ? 'selected' : '' }}>Kepala</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    <a href="{{ route('admin-panitia.accounts') }}" class="px-6 py-3 bg-slate-600 text-white rounded-lg hover:bg-slate-700">
                        <i class="fas fa-refresh mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">
            <div class="px-6 py-5 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-purple-50">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-slate-800">Daftar User</h3>
                    <span class="text-sm text-slate-600">{{ $users->count() }} user ditemukan</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Bergabung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 {{ request('search') && (stripos($user->name, request('search')) !== false || stripos($user->email, request('search')) !== false) ? 'bg-yellow-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-slate-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->role == 'admin')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>
                                @elseif($user->role == 'verifikator')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Verifikator</span>
                                @elseif($user->role == 'keuangan')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Keuangan</span>
                                @elseif($user->role == 'siswa')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Siswa</span>
                                @elseif($user->role == 'kepala' || $user->role == 'kepala_sekolah')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Kepala Sekolah</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($user->role) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $user->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button onclick="editUser({{ $user->id }})" class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                    @if($user->id != auth()->id())
                                    <button onclick="deleteUser({{ $user->id }})" class="bg-red-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-red-700 transition-colors">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                <i class="fas fa-users text-4xl mb-4 text-slate-300"></i>
                                <p class="text-lg font-medium">Tidak ada user ditemukan</p>
                                @if(request('search') || request('role'))
                                <p class="text-sm mt-2">Coba ubah kriteria pencarian atau filter</p>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
    {{ session('error') }}
</div>
@endif

<!-- Add User Modal -->
<div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Tambah User Baru</h3>
            <button onclick="closeAddUserModal()" class="text-slate-500 hover:text-slate-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin-panitia.store-user') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
                    <select name="role" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="verifikator">Verifikator</option>
                        <option value="keuangan">Keuangan</option>
                        <option value="siswa">Siswa</option>
                        <option value="kepala">Kepala Sekolah</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Telepon</label>
                    <input type="text" name="phone" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="submit" class="flex-1 bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700">
                    <i class="fas fa-plus mr-2"></i>Tambah
                </button>
                <button type="button" onclick="closeAddUserModal()" class="flex-1 bg-slate-600 text-white py-3 rounded-lg hover:bg-slate-700">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Edit User</h3>
            <button onclick="closeEditUserModal()" class="text-slate-500 hover:text-slate-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
                    <input type="text" name="name" id="edit_name" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" id="edit_email" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
                    <select name="role" id="edit_role" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                        <option value="admin">Admin</option>
                        <option value="verifikator">Verifikator</option>
                        <option value="keuangan">Keuangan</option>
                        <option value="siswa">Siswa</option>
                        <option value="kepala">Kepala Sekolah</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Telepon</label>
                    <input type="text" name="phone" id="edit_phone" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
                <button type="button" onclick="closeEditUserModal()" class="flex-1 bg-slate-600 text-white py-3 rounded-lg hover:bg-slate-700">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddUserModal() {
    document.getElementById('addUserModal').classList.remove('hidden');
}

function closeAddUserModal() {
    document.getElementById('addUserModal').classList.add('hidden');
}

function closeEditUserModal() {
    document.getElementById('editUserModal').classList.add('hidden');
}

function editUser(userId) {
    fetch(`/admin-panitia/users/${userId}`)
        .then(response => response.json())
        .then(user => {
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_role').value = user.role;
            document.getElementById('edit_phone').value = user.phone || '';
            document.getElementById('editUserForm').action = `/admin-panitia/users/${userId}`;
            document.getElementById('editUserModal').classList.remove('hidden');
        });
}

function deleteUser(userId) {
    if (confirm('Yakin ingin menghapus user ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin-panitia/users/${userId}`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto hide alerts
setTimeout(() => {
    const alerts = document.querySelectorAll('.fixed.top-4.right-4');
    alerts.forEach(alert => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    });
}, 3000);
</script>
@endsection