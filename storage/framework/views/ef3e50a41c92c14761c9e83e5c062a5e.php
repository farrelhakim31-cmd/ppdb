<?php $__env->startSection('title', 'Verifikasi OTP - PPDB Online'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center px-4 py-12" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-xl shadow-lg border-0">
            <div class="text-center bg-blue-600 text-white rounded-t-xl p-4">
                <h4 class="text-xl font-bold mb-0"><i class="fas fa-shield-alt mr-2"></i>Verifikasi OTP</h4>
            </div>
            <div class="p-6">
                <div class="text-center mb-6">
                    <?php if($delivery_method === 'email'): ?>
                        <i class="fas fa-envelope-open-text text-4xl text-blue-600 mb-4"></i>
                        <p class="text-gray-600 mb-2">Kode OTP telah dikirim ke email:</p>
                        <strong class="text-gray-800"><?php echo e($email); ?></strong>
                    <?php elseif($delivery_method === 'sms'): ?>
                        <i class="fas fa-sms text-4xl text-green-600 mb-4"></i>
                        <p class="text-gray-600 mb-2">Kode OTP telah dikirim via SMS ke:</p>
                        <strong class="text-gray-800"><?php echo e($user->phone); ?></strong>
                    <?php elseif($delivery_method === 'whatsapp'): ?>
                        <i class="fab fa-whatsapp text-4xl text-green-500 mb-4"></i>
                        <p class="text-gray-600 mb-2">Kode OTP telah dikirim via WhatsApp ke:</p>
                        <strong class="text-gray-800"><?php echo e($user->phone); ?></strong>
                    <?php endif; ?>
                </div>

                <?php if($errors->any()): ?>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                            <span class="text-red-700"><?php echo e($errors->first()); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if(session('success')): ?>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span class="text-green-700"><?php echo e(session('success')); ?></span>
                        </div>

                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('otp.verify')); ?>" method="POST" id="otpForm" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="otp_code" class="block text-sm font-medium text-gray-700 mb-2">Masukkan Kode OTP</label>
                        <input type="text" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-2xl" 
                               id="otp_code" 
                               name="otp_code" 
                               maxlength="6" 
                               pattern="[0-9]{6}"
                               placeholder="000000"
                               style="letter-spacing: 0.5em;"
                               required>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-check mr-2"></i>Verifikasi
                    </button>
                </form>

                <div class="text-center mt-6">
                    <p class="text-gray-600 mb-2">Tidak menerima kode?</p>
                    <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors" id="resendBtn">
                        <i class="fas fa-redo mr-2"></i>Kirim Ulang OTP
                    </button>
                    <div class="mt-2">
                        <span class="text-gray-600">Kirim ulang dalam: </span>
                        <span id="countdown" class="text-blue-600 font-bold">60</span>
                        <span class="text-gray-600"> detik</span>
                    </div>
                    <div class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded">
                        <span class="text-yellow-700 text-sm">
                            <i class="fas fa-clock mr-1"></i>
                            Session akan berakhir dalam: <span id="sessionCountdown" class="font-bold">15:00</span>
                        </span>
                    </div>
                </div>

                <div class="text-center mt-6">
                    <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:text-blue-700 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp_code');
    const resendBtn = document.getElementById('resendBtn');
    const countdownEl = document.getElementById('countdown');
    const sessionCountdownEl = document.getElementById('sessionCountdown');
    let countdown = 60;
    let countdownInterval;
    let sessionCountdown = 15 * 60; // 15 menit dalam detik
    let sessionInterval;

    // Auto format OTP input
    otpInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length === 6) {
            document.getElementById('otpForm').submit();
        }
    });

    // Countdown timer
    function startCountdown() {
        resendBtn.disabled = true;
        resendBtn.classList.add('opacity-50', 'cursor-not-allowed');
        countdownInterval = setInterval(function() {
            countdown--;
            countdownEl.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                resendBtn.disabled = false;
                resendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                countdownEl.textContent = '0';
                countdown = 60;
            }
        }, 1000);
    }

    // Resend OTP
    resendBtn.addEventListener('click', function() {
        fetch('<?php echo e(route("otp.resend")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Kode OTP baru telah dikirim!');

                startCountdown();
            } else {
                if (data.redirect) {
                    alert('Session expired. Anda akan diarahkan ke halaman login.');
                    window.location.href = data.redirect;
                } else {
                    alert('Gagal mengirim OTP: ' + data.message);
                }
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });

    // Session countdown timer
    function startSessionCountdown() {
        sessionInterval = setInterval(function() {
            sessionCountdown--;
            
            const minutes = Math.floor(sessionCountdown / 60);
            const seconds = sessionCountdown % 60;
            sessionCountdownEl.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
            
            if (sessionCountdown <= 0) {
                clearInterval(sessionInterval);
                alert('Session telah berakhir. Anda akan diarahkan ke halaman login.');
                window.location.href = '<?php echo e(route("login")); ?>';
            }
        }, 1000);
    }

    // Start initial countdown
    startCountdown();
    startSessionCountdown();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/auth/otp-verification.blade.php ENDPATH**/ ?>