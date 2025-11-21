<?php $__env->startSection('title', 'Peta Sebaran - Admin Panitia'); ?>

<?php
    $mapSettings = \App\Models\MapSetting::getSettings();
?>

<?php $__env->startSection('head'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-purple-50">
    <div class="bg-white shadow-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Peta Sebaran Pendaftar</h1>
                    <p class="text-slate-600 mt-1"><?php echo e($mapSettings->school_name); ?></p>
                </div>
                <a href="<?php echo e(route('admin-panitia.dashboard')); ?>" class="bg-gradient-to-r from-slate-600 to-slate-700 text-white px-6 py-3 rounded-xl hover:from-slate-700 hover:to-slate-800 transition-all duration-200 shadow-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-4 lg:gap-6">
            <!-- Map -->
            <div class="xl:col-span-3 order-2 xl:order-1">
                <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                    <div class="px-4 lg:px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg lg:text-xl font-bold text-slate-800">Peta Interaktif</h3>
                    </div>
                    <div id="map" class="h-64 sm:h-80 lg:h-96 xl:h-[500px]"></div>
                </div>
            </div>

            <!-- Legend & Stats -->
            <div class="space-y-4 lg:space-y-6 order-1 xl:order-2">
                <!-- Legend -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
                    <h4 class="text-lg font-bold text-slate-800 mb-4">Legenda Jurusan</h4>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full mr-3"></div>
                            <span class="text-sm text-slate-600">PPLG</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-slate-600">Akuntansi</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3"></div>
                            <span class="text-sm text-slate-600">Animasi</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full mr-3"></div>
                            <span class="text-sm text-slate-600">DKV</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-purple-500 rounded-full mr-3"></div>
                            <span class="text-sm text-slate-600">BDP</span>
                        </div>
                    </div>
                </div>

                <!-- Stats per Wilayah -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
                    <h4 class="text-lg font-bold text-slate-800 mb-4">Sebaran per Wilayah</h4>
                    <div class="space-y-3">
                        <?php
                            $wilayah_stats = [];
                            foreach($sebaran as $item) {
                                $wilayah = explode(',', $item->address)[0] ?? 'Tidak Diketahui';
                                if (!isset($wilayah_stats[$wilayah])) {
                                    $wilayah_stats[$wilayah] = 0;
                                }
                                $wilayah_stats[$wilayah] += $item->total;
                            }
                            arsort($wilayah_stats);
                        ?>
                        <?php $__currentLoopData = array_slice($wilayah_stats, 0, 10, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wilayah => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600"><?php echo e($wilayah); ?></span>
                            <span class="text-sm font-bold text-slate-800"><?php echo e($total); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize map
var map = L.map('map').setView([<?php echo e($mapSettings->latitude); ?>, <?php echo e($mapSettings->longitude); ?>], <?php echo e($mapSettings->zoom_level); ?>);

// Add tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Color mapping for majors
const majorColors = {
    'PPLG': '#3b82f6',
    'Akuntansi': '#10b981',
    'Animasi': '#f59e0b',
    'DKV': '#ef4444',
    'BDP': '#8b5cf6'
};

// School location marker
L.marker([<?php echo e($mapSettings->latitude); ?>, <?php echo e($mapSettings->longitude); ?>]).addTo(map)
    .bindPopup('<div class="p-2"><h5 class="font-bold text-purple-600"><?php echo e($mapSettings->school_name); ?></h5><p class="text-sm"><?php echo e($mapSettings->school_address); ?></p></div>');

// Sample data points around school area
const samplePoints = [
    {lat: -6.9350, lng: 107.7150, major: 'PPLG', count: 25, address: 'Cileunyi Kulon'},
    {lat: -6.9420, lng: 107.7220, major: 'Akuntansi', count: 20, address: 'Cileunyi Wetan'},
    {lat: -6.9300, lng: 107.7100, major: 'Animasi', count: 15, address: 'Rancaekek'},
    {lat: -6.9450, lng: 107.7250, major: 'DKV', count: 18, address: 'Cinunuk'},
    {lat: -6.9380, lng: 107.7180, major: 'BDP', count: 12, address: 'Cileunyi'}
];

// Add markers to map
samplePoints.forEach(point => {
    const color = majorColors[point.major] || '#6b7280';
    
    const marker = L.circleMarker([point.lat, point.lng], {
        radius: Math.sqrt(point.count) * 3,
        fillColor: color,
        color: '#ffffff',
        weight: 2,
        opacity: 1,
        fillOpacity: 0.7
    }).addTo(map);
    
    marker.bindPopup(`
        <div class="p-2">
            <h5 class="font-bold">${point.address}</h5>
            <p class="text-sm">Jurusan: ${point.major}</p>
            <p class="text-sm">Jumlah: ${point.count} pendaftar</p>
        </div>
    `);
});

// Add legend to map
const legend = L.control({position: 'bottomright'});
legend.onAdd = function (map) {
    const div = L.DomUtil.create('div', 'info legend');
    div.innerHTML = '<h4 class="text-sm font-bold mb-2">Ukuran Lingkaran</h4>';
    div.innerHTML += '<p class="text-xs">Semakin besar = Semakin banyak pendaftar</p>';
    div.style.backgroundColor = 'white';
    div.style.padding = '10px';
    div.style.borderRadius = '8px';
    div.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
    return div;
};
legend.addTo(map);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/admin-panitia/map.blade.php ENDPATH**/ ?>