@extends('layouts.admin')

@section('title', 'Pengaturan Peta')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Pengaturan Peta Sekolah</h3>
                    <a href="{{ route('admin-panitia.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.map-settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Sekolah</label>
                                    <input type="text" name="school_name" class="form-control @error('school_name') is-invalid @enderror" 
                                           value="{{ old('school_name', $setting->school_name) }}" required>
                                    @error('school_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Sekolah</label>
                                    <div class="input-group">
                                        <textarea name="school_address" class="form-control @error('school_address') is-invalid @enderror" 
                                                  rows="3" required>{{ old('school_address', $setting->school_address) }}</textarea>
                                        <button type="button" class="btn btn-outline-secondary" onclick="searchLocation()" title="Cari lokasi berdasarkan alamat">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    @error('school_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Latitude</label>
                                            <input type="number" step="0.00000001" name="latitude" 
                                                   class="form-control @error('latitude') is-invalid @enderror" 
                                                   value="{{ old('latitude', $setting->latitude) }}" required>
                                            @error('latitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Longitude</label>
                                            <input type="number" step="0.00000001" name="longitude" 
                                                   class="form-control @error('longitude') is-invalid @enderror" 
                                                   value="{{ old('longitude', $setting->longitude) }}" required>
                                            @error('longitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Zoom Level (1-20)</label>
                                    <input type="number" min="1" max="20" name="zoom_level" 
                                           class="form-control @error('zoom_level') is-invalid @enderror" 
                                           value="{{ old('zoom_level', $setting->zoom_level) }}" required>
                                    @error('zoom_level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Pengaturan
                                </button>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Preview Peta</label>
                                    <div class="alert alert-info alert-sm mb-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <small>Klik dan drag marker untuk mengubah lokasi</small>
                                    </div>
                                    <div id="map" style="height: 400px; border-radius: 8px;"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
let map = L.map('map').setView([{{ $setting->latitude }}, {{ $setting->longitude }}], {{ $setting->zoom_level }});
let marker;

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

marker = L.marker([{{ $setting->latitude }}, {{ $setting->longitude }}], {draggable: true}).addTo(map)
    .bindPopup('<b>{{ $setting->school_name }}</b><br>{{ $setting->school_address }}');

// Update coordinates when marker is dragged
marker.on('dragend', function(e) {
    const position = e.target.getLatLng();
    document.querySelector('input[name="latitude"]').value = position.lat.toFixed(8);
    document.querySelector('input[name="longitude"]').value = position.lng.toFixed(8);
});

// Add marker on map click
map.on('click', function(e) {
    const lat = e.latlng.lat;
    const lng = e.latlng.lng;
    
    // Update form inputs
    document.querySelector('input[name="latitude"]').value = lat.toFixed(8);
    document.querySelector('input[name="longitude"]').value = lng.toFixed(8);
    
    // Move marker to new position
    if (marker) {
        map.removeLayer(marker);
    }
    marker = L.marker([lat, lng], {draggable: true}).addTo(map)
        .bindPopup('<b>' + document.querySelector('input[name="school_name"]').value + '</b><br>' + 
                  document.querySelector('textarea[name="school_address"]').value);
    
    // Re-add drag event
    marker.on('dragend', function(e) {
        const position = e.target.getLatLng();
        document.querySelector('input[name="latitude"]').value = position.lat.toFixed(8);
        document.querySelector('input[name="longitude"]').value = position.lng.toFixed(8);
    });
});

// Update map when coordinates change
document.querySelector('input[name="latitude"]').addEventListener('input', updateMap);
document.querySelector('input[name="longitude"]').addEventListener('input', updateMap);
document.querySelector('input[name="zoom_level"]').addEventListener('input', updateMap);

function updateMap() {
    const lat = parseFloat(document.querySelector('input[name="latitude"]').value);
    const lng = parseFloat(document.querySelector('input[name="longitude"]').value);
    const zoom = parseInt(document.querySelector('input[name="zoom_level"]').value);
    
    if (!isNaN(lat) && !isNaN(lng) && !isNaN(zoom)) {
        map.setView([lat, lng], zoom);
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lng], {draggable: true}).addTo(map)
            .bindPopup('<b>' + document.querySelector('input[name="school_name"]').value + '</b><br>' + 
                      document.querySelector('textarea[name="school_address"]').value);
        
        // Re-add drag event for new marker
        marker.on('dragend', function(e) {
            const position = e.target.getLatLng();
            document.querySelector('input[name="latitude"]').value = position.lat.toFixed(8);
            document.querySelector('input[name="longitude"]').value = position.lng.toFixed(8);
        });
}

// Search location based on address
function searchLocation() {
    const address = document.querySelector('textarea[name="school_address"]').value;
    if (!address.trim()) {
        alert('Masukkan alamat terlebih dahulu');
        return;
    }
    
    // Using Nominatim geocoding service
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lng = parseFloat(data[0].lon);
                
                // Update form inputs
                document.querySelector('input[name="latitude"]').value = lat.toFixed(8);
                document.querySelector('input[name="longitude"]').value = lng.toFixed(8);
                
                // Update map
                updateMap();
                
                // Show success message
                alert('Lokasi ditemukan dan peta telah diperbarui!');
            } else {
                alert('Lokasi tidak ditemukan. Silakan coba alamat yang lebih spesifik.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mencari lokasi.');
        });
    }
}

// Update school name and address in popup when changed
document.querySelector('input[name="school_name"]').addEventListener('input', updatePopup);
document.querySelector('textarea[name="school_address"]').addEventListener('input', updatePopup);

function updatePopup() {
    if (marker) {
        const schoolName = document.querySelector('input[name="school_name"]').value;
        const schoolAddress = document.querySelector('textarea[name="school_address"]').value;
        marker.setPopupContent('<b>' + schoolName + '</b><br>' + schoolAddress);
    }
}
</script>
@endsection