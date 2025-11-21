<?php $__env->startSection('title', 'Pengaturan Peta'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Pengaturan Peta Sekolah</h3>
                    <a href="<?php echo e(route('admin-panitia.dashboard')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.map-settings.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Sekolah</label>
                                    <input type="text" name="school_name" class="form-control <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('school_name', $setting->school_name)); ?>" required>
                                    <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Sekolah</label>
                                    <div class="input-group">
                                        <textarea name="school_address" class="form-control <?php $__errorArgs = ['school_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                  rows="3" required><?php echo e(old('school_address', $setting->school_address)); ?></textarea>
                                        <button type="button" class="btn btn-outline-secondary" onclick="searchLocation()" title="Cari lokasi berdasarkan alamat">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    <?php $__errorArgs = ['school_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Latitude</label>
                                            <input type="number" step="0.00000001" name="latitude" 
                                                   class="form-control <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   value="<?php echo e(old('latitude', $setting->latitude)); ?>" required>
                                            <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Longitude</label>
                                            <input type="number" step="0.00000001" name="longitude" 
                                                   class="form-control <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   value="<?php echo e(old('longitude', $setting->longitude)); ?>" required>
                                            <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Zoom Level (1-20)</label>
                                    <input type="number" min="1" max="20" name="zoom_level" 
                                           class="form-control <?php $__errorArgs = ['zoom_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           value="<?php echo e(old('zoom_level', $setting->zoom_level)); ?>" required>
                                    <?php $__errorArgs = ['zoom_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
let map = L.map('map').setView([<?php echo e($setting->latitude); ?>, <?php echo e($setting->longitude); ?>], <?php echo e($setting->zoom_level); ?>);
let marker;

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

marker = L.marker([<?php echo e($setting->latitude); ?>, <?php echo e($setting->longitude); ?>], {draggable: true}).addTo(map)
    .bindPopup('<b><?php echo e($setting->school_name); ?></b><br><?php echo e($setting->school_address); ?>');

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/admin/map-settings.blade.php ENDPATH**/ ?>