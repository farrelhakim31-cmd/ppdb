// PPDB Form JavaScript Functions
class PPDBForm {
    constructor() {
        this.currentStep = 1;
        this.formData = {};
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupValidation();
        this.setupFileUpload();
    }

    setupEventListeners() {
        // Add input event listeners for real-time validation
        document.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', (e) => {
                this.validateField(e.target);
                this.saveFieldData(e.target);
            });
            
            field.addEventListener('blur', (e) => {
                this.validateField(e.target);
            });
        });

        // Phone number formatting
        document.querySelectorAll('input[name="phone"], input[name="parent_phone"]').forEach(phone => {
            phone.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9+\-\s]/g, '');
            });
        });

        // Name validation (only letters and spaces)
        document.querySelectorAll('input[name="name"], input[name="parent_name"], input[name="birth_place"]').forEach(nameField => {
            nameField.addEventListener('input', function() {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });
        });

        // Form submission
        const form = document.getElementById('registrationForm');
        if (form) {
            form.addEventListener('submit', (e) => this.handleSubmit(e));
        }
    }

    setupValidation() {
        // Email validation
        const emailField = document.querySelector('input[name="email"]');
        if (emailField) {
            emailField.addEventListener('input', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.setCustomValidity('Format email tidak valid');
                } else {
                    this.setCustomValidity('');
                }
            });
        }

        // Date validation
        const dateField = document.querySelector('input[name="birth_date"]');
        if (dateField) {
            dateField.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                const minAge = new Date();
                minAge.setFullYear(today.getFullYear() - 25); // Max age 25

                if (selectedDate >= today) {
                    this.setCustomValidity('Tanggal lahir harus sebelum hari ini');
                } else if (selectedDate < minAge) {
                    this.setCustomValidity('Usia maksimal 25 tahun');
                } else {
                    this.setCustomValidity('');
                }
            });
        }
    }

    setupFileUpload() {
        const fileInput = document.getElementById('documents');
        if (fileInput) {
            fileInput.addEventListener('change', (e) => this.handleFileUpload(e));
        }
    }

    showStep(step) {
        // Hide all steps with animation
        document.querySelectorAll('.step-content').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateX(-20px)';
            setTimeout(() => el.classList.add('hidden'), 150);
        });

        // Show current step with animation
        setTimeout(() => {
            const currentStepEl = document.getElementById(`step${step}`);
            if (currentStepEl) {
                currentStepEl.classList.remove('hidden');
                currentStepEl.style.opacity = '0';
                currentStepEl.style.transform = 'translateX(20px)';
                
                setTimeout(() => {
                    currentStepEl.style.opacity = '1';
                    currentStepEl.style.transform = 'translateX(0)';
                }, 50);
            }
        }, 150);

        // Update indicators
        this.updateStepIndicators(step);
    }

    updateStepIndicators(step) {
        for (let i = 1; i <= 3; i++) {
            const indicator = document.getElementById(`step${i}-indicator`);
            const text = indicator?.nextElementSibling;
            
            if (indicator && text) {
                if (i <= step) {
                    indicator.classList.remove('bg-gray-300', 'text-gray-500');
                    indicator.classList.add('bg-blue-500', 'text-white');
                    text.classList.remove('text-gray-500');
                    text.classList.add('text-gray-700');
                } else {
                    indicator.classList.remove('bg-blue-500', 'text-white');
                    indicator.classList.add('bg-gray-300', 'text-gray-500');
                    text.classList.remove('text-gray-700');
                    text.classList.add('text-gray-500');
                }
            }
        }
    }

    nextStep(step) {
        if (this.validateCurrentStep()) {
            this.currentStep = step;
            this.showStep(step);
            this.scrollToTop();
        }
    }

    prevStep(step) {
        this.currentStep = step;
        this.showStep(step);
        this.scrollToTop();
    }

    validateCurrentStep() {
        const currentStepEl = document.getElementById(`step${this.currentStep}`);
        if (!currentStepEl) return false;

        const requiredFields = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        let firstInvalidField = null;

        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            }
        });

        if (!isValid) {
            this.showNotification('Mohon lengkapi semua field yang wajib diisi dengan benar!', 'error');
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        }

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Field ini wajib diisi';
        }

        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Format email tidak valid';
            }
        }

        // Phone validation
        if ((field.name === 'phone' || field.name === 'parent_phone') && value) {
            if (value.length < 10 || value.length > 15) {
                isValid = false;
                errorMessage = 'Nomor telepon harus 10-15 digit';
            }
        }

        // Date validation
        if (field.type === 'date' && value) {
            const selectedDate = new Date(value);
            const today = new Date();
            if (selectedDate >= today) {
                isValid = false;
                errorMessage = 'Tanggal lahir harus sebelum hari ini';
            }
        }

        // Address validation
        if (field.name === 'address' && value && value.length < 10) {
            isValid = false;
            errorMessage = 'Alamat minimal 10 karakter';
        }

        // Update field appearance
        this.updateFieldAppearance(field, isValid, errorMessage);

        return isValid;
    }

    updateFieldAppearance(field, isValid, errorMessage) {
        if (isValid) {
            field.classList.remove('border-red-500');
            field.classList.add('border-green-500');
            this.removeFieldError(field);
        } else {
            field.classList.remove('border-green-500');
            field.classList.add('border-red-500');
            this.showFieldError(field, errorMessage);
        }
    }

    showFieldError(field, message) {
        this.removeFieldError(field);
        const errorEl = document.createElement('p');
        errorEl.className = 'text-red-500 text-sm mt-1 field-error';
        errorEl.textContent = message;
        field.parentNode.appendChild(errorEl);
    }

    removeFieldError(field) {
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
    }

    saveFieldData(field) {
        this.formData[field.name] = field.value;
    }

    handleFileUpload(e) {
        const files = e.target.files;
        const maxSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        let validFiles = [];

        Array.from(files).forEach(file => {
            if (file.size > maxSize) {
                this.showNotification(`File ${file.name} terlalu besar (maksimal 2MB)`, 'error');
                return;
            }

            if (!allowedTypes.includes(file.type)) {
                this.showNotification(`File ${file.name} format tidak didukung`, 'error');
                return;
            }

            validFiles.push(file);
        });

        if (validFiles.length > 0) {
            const label = document.querySelector('label[for="documents"] span');
            if (label) {
                label.textContent = `${validFiles.length} file(s) dipilih`;
                label.parentElement.classList.add('text-green-600');
            }
            this.showFileList(validFiles);
        }
    }

    showFileList(files) {
        const existingList = document.querySelector('.file-list');
        if (existingList) existingList.remove();

        const fileList = document.createElement('div');
        fileList.className = 'file-list mt-4 space-y-2';

        files.forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-lg';
            fileItem.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">${file.name}</span>
                </div>
                <span class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
            `;
            fileList.appendChild(fileItem);
        });

        const uploadArea = document.querySelector('.border-dashed').parentNode;
        if (uploadArea) {
            uploadArea.appendChild(fileList);
        }
    }

    handleSubmit(e) {
        const submitBtn = e.target.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;

            // Re-enable button after 10 seconds as fallback
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 10000);
        }
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        const bgColor = type === 'error' ? 'bg-red-500' : type === 'success' ? 'bg-green-500' : 'bg-blue-500';
        
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg z-50 fade-in`;
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                ${message}
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }

    scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// Initialize PPDB Form when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('registrationForm')) {
        window.ppdbForm = new PPDBForm();
    }
});

// Global functions for button onclick events
function nextStep(step) {
    if (window.ppdbForm) {
        window.ppdbForm.nextStep(step);
    }
}

function prevStep(step) {
    if (window.ppdbForm) {
        window.ppdbForm.prevStep(step);
    }
}