$(document).ready(function () {
    // Fetch nationalities via Select2 AJAX
    $('#nationality').select2({
        placeholder: 'Select your nationality',
        allowClear: true,
        width: '100%',
        ajax: {
            url: '/nationalities',
            dataType: 'json',
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
    // Remove manual AJAX for hobbies, use only Select2 AJAX for hobby
    $('#hobby').select2({
        placeholder: 'Select your hobby',
        allowClear: true,
        width: '100%',
        ajax: {
            url: '/hobbies',
            dataType: 'json',
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
});

// Step JS form 
const steps = document.querySelectorAll(".step-content");
const buttons = document.querySelectorAll(".step-button");
const nextBtns = document.querySelectorAll(".next-btn");
const prevBtns = document.querySelectorAll(".prev-btn");
let currentStep = 1;

function showStep(step) {
    steps.forEach((el) => {
        el.classList.remove("active");
    });
    document.querySelector(`.step-content[data-step="${step}"]`).classList.add("active");

    buttons.forEach((btn) => {
        const stepNum = parseInt(btn.getAttribute("data-step"));
        if (stepNum === step) {
            btn.classList.remove("btn-outline-secondary");
            btn.classList.add("btn-primary");
        } else {
            btn.classList.add("btn-outline-secondary");
            btn.classList.remove("btn-primary");
        }
    });

    currentStep = step;
}

buttons.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const step = parseInt(btn.getAttribute("data-step"));
        let valid = true;
        // Only restrict forward navigation
        if (step > currentStep) {
            if (currentStep === 1) valid = validateStep1();
            if (currentStep === 2) valid = validateStep2();
            if (currentStep === 3) valid = validateStep3();
            if (currentStep === 4) valid = validateStep4();
            if (!valid) {
                e.preventDefault();
                return;
            }
        }
        showStep(step);
    });
});

nextBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        // Find the current step
        const currentStepDiv = document.querySelector('.step-content.active');
        const step = parseInt(currentStepDiv.getAttribute('data-step'));
        let valid = true;
        if (step === 1) valid = validateStep1();
        if (step === 2) valid = validateStep2();
        if (step === 3) valid = validateStep3();
        if (step === 4) valid = validateStep4();
        if (!valid) {
            e.preventDefault();
            return;
        }
        if (currentStep < steps.length) {
            showStep(currentStep + 1);
        }
    });
});

prevBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });
});

// Init intl-tel-input
const phoneInput = document.querySelector("#phone-number");
const phoneError = document.getElementById("phone-error");
let iti = null;
if (phoneInput) {
    iti = window.intlTelInput(phoneInput, {
        initialCountry: "bd",
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
    });
}

// Initialize first step
showStep(1);


// Add academic row
document.addEventListener('DOMContentLoaded', function () {
    const academicRows = document.getElementById('academic-rows');

    // Function to add a new row
    function addNewRow() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
    <td>
        <input type="text" class="form-control" placeholder="Enter Education Level">
    </td>
    <td>
        <input type="text" class="form-control" placeholder="Enter Department">
    </td>
    <td>
        <input type="text" class="form-control" placeholder="Enter Institute Name">
    </td>
    <td>
        <div class="input-group">
            <input type="text" class="form-control passing-year" placeholder="Enter Passing Year" autocomplete="off">
            <span class="input-group-text psIcon" style="cursor: pointer;">
                <i class="bi bi-calendar"></i>
            </span>
        </div>
    </td>
    <td>
        <input type="number" class="form-control" placeholder="Enter CGPA">
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-danger remove-academic-row">
            <i class="fas fa-minus"></i>
        </button>
    </td>
`;
        academicRows.appendChild(newRow);

        // Add event listener to the new remove button
        newRow.querySelector('.remove-academic-row').addEventListener('click', function () {
            academicRows.removeChild(newRow);
        });

        // Add year-only datepicker to new row
        $(newRow).find('.passing-year').datepicker({
            dateFormat: "yy",
            changeMonth: false,
            changeYear: true,
            yearRange: "1900:2025",
            maxDate: 0,
            showButtonPanel: true,
            beforeShow: function (input, inst) {
                // Hide month and calendar grid, show only year and Done
                setTimeout(function () {
                    $(inst.dpDiv).find('.ui-datepicker-month').hide();
                    $(inst.dpDiv).find('.ui-datepicker-calendar').hide();
                    // Custom Done button handler
                    $('.ui-datepicker-close').off('click').on('click', function () {
                        var year = $(input).datepicker('widget').find('.ui-datepicker-year :selected').val();
                        $(input).val(year);
                        $(input).datepicker('hide');
                    });
                }, 1);
            },
            onChangeMonthYear: function (year, month, inst) {
                setTimeout(function () {
                    $(inst.dpDiv).find('.ui-datepicker-month').hide();
                    $(inst.dpDiv).find('.ui-datepicker-calendar').hide();
                }, 1);
            },
            onClose: function (dateText, inst) {
                // Always set value to selected year from dropdown
                var year = $(this).datepicker('widget').find('.ui-datepicker-year :selected').val();
                if (year) $(this).val(year);
            }
        });
        // Icon click opens datepicker for this row
        $(newRow).find('.psIcon').on('click', function () {
            $(this).siblings('.passing-year').datepicker('show');
        });
    }

    // Add event listener to the initial add button
    document.querySelector('.add-academic-row').addEventListener('click', addNewRow);

    // Initialize year-only datepicker for existing rows
    $('#academic-rows .passing-year').datepicker({
        dateFormat: "yy",
        changeMonth: false,
        changeYear: true,
        yearRange: "1900:2025",
        maxDate: 0,
        showButtonPanel: true,
        beforeShow: function (input, inst) {
            setTimeout(function () {
                $(inst.dpDiv).find('.ui-datepicker-month').hide();
                $(inst.dpDiv).find('.ui-datepicker-calendar').hide();
                $('.ui-datepicker-close').off('click').on('click', function () {
                    var year = $(input).datepicker('widget').find('.ui-datepicker-year :selected').val();
                    $(input).val(year);
                    $(input).datepicker('hide');
                });
            }, 1);
        },
        onChangeMonthYear: function (year, month, inst) {
            setTimeout(function () {
                $(inst.dpDiv).find('.ui-datepicker-month').hide();
                $(inst.dpDiv).find('.ui-datepicker-calendar').hide();
            }, 1);
        },
        onClose: function (dateText, inst) {
            var year = $(this).datepicker('widget').find('.ui-datepicker-year :selected').val();
            if (year) $(this).val(year);
        }
    });
    // Icon click for existing rows
    $('#academic-rows .psIcon').on('click', function () {
        $(this).siblings('.passing-year').datepicker('show');
    });
});

// Add experience row
document.addEventListener('DOMContentLoaded', function () {
    const experienceTableBody = document.getElementById('experience-table-body');

    // Function to add a new experience row
    function addExperienceRow() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
    <td>
        <input type="text" class="form-control" placeholder="Enter Company Name">
    </td>
    <td>
        <input type="text" class="form-control" placeholder="Enter Designation">
    </td>
    <td>
        <input type="text" class="form-control" placeholder="Enter Location">
    </td>
    <td>
        <div class="input-group">
            <input type="text" class="form-control start-date" placeholder="Start Date" autocomplete="off">
            <span class="input-group-text calendar-icon" style="cursor: pointer;">
                <i class="bi bi-calendar"></i>
            </span>
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="text" class="form-control end-date" placeholder="End Date" autocomplete="off">
            <span class="input-group-text calendar-icon" style="cursor: pointer;">
                <i class="bi bi-calendar"></i>
            </span>
        </div>
    </td>
    <td>
        <input type="number" class="form-control total-years" placeholder="Years" readonly>
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-danger remove-experience-row">
            <i class="fas fa-minus"></i>
        </button>
    </td>
`;
        experienceTableBody.appendChild(newRow);

        // Add event listener to the new remove button
        newRow.querySelector('.remove-experience-row').addEventListener('click', function () {
            experienceTableBody.removeChild(newRow);
        });

        // Add datepicker to new row
        $(newRow).find('.start-date, .end-date').datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "1950:2025",
            maxDate: 0
        });

        // Add date change listeners to calculate duration for this row only
        setupDateListeners(newRow);
    }

    // Function to setup date change listeners for a row
    function setupDateListeners(row) {
        const startDateInput = row.querySelector('.start-date');
        const endDateInput = row.querySelector('.end-date');
        const yearsInput = row.querySelector('.total-years');

        function updateYears() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            if (!isNaN(startDate) && !isNaN(endDate) && endDate >= startDate) {
                const diffTime = endDate - startDate;
                const diffYears = diffTime / (1000 * 60 * 60 * 24 * 365.25); // includes leap years
                yearsInput.value = diffYears.toFixed(1); // 1 decimal precision
            } else {
                yearsInput.value = '';
            }
        }

        // Listen to both 'input' and 'change' events for manual typing and datepicker
        startDateInput.addEventListener('input', updateYears);
        endDateInput.addEventListener('input', updateYears);
        startDateInput.addEventListener('change', updateYears);
        endDateInput.addEventListener('change', updateYears);

        // Also trigger calculation when date is picked via datepicker
        $(startDateInput).datepicker('option', 'onSelect', function () { updateYears(); });
        $(endDateInput).datepicker('option', 'onSelect', function () { updateYears(); });
    }

    // Add event listener to the initial add button
    document.querySelector('.add-experience-row').addEventListener('click', addExperienceRow);

    // Setup datepickers and listeners for all existing rows (including first row)
    experienceTableBody.querySelectorAll('tr').forEach(function (row) {
        $(row).find('.start-date, .end-date').datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            yearRange: "1950:2025",
            maxDate: 0
        });
        setupDateListeners(row);
    });
});

// Add training row
document.addEventListener('DOMContentLoaded', function () {
    const trainingTableBody = document.getElementById('training-table-body');

    // Function to add a new training row
    window.addTrainingRow = function () {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
    <td>
        <input type="text" class="form-control" placeholder="Enter Training Title">
    </td>
    <td>
        <input type="text" class="form-control" placeholder="Enter Institute Name">
    </td>
    <td>
        <input type="number" class="form-control" placeholder="Enter Duration">
    </td>
    <td>
        <div class="input-group">
            <input type="text" class="form-control training-year" placeholder="Enter Training Year" autocomplete="off">
            <span class="input-group-text tyIcon" style="cursor: pointer;">
                <i class="bi bi-calendar"></i>
            </span>
        </div>
    </td>
    <td>
        <input type="text" class="form-control" placeholder="Enter Location">
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-danger remove-training-row">
            <i class="fas fa-minus"></i>
        </button>
    </td>
`;
        trainingTableBody.appendChild(newRow);

        // Add event listener to the new remove button
        newRow.querySelector('.remove-training-row').addEventListener('click', function () {
            trainingTableBody.removeChild(newRow);
        });

        // Add year-only datepicker to new row
        $(newRow).find('.training-year').datepicker({
            dateFormat: "yy",
            changeMonth: false,
            changeYear: true,
            yearRange: "1950:2025",
            maxDate: 0,
            showButtonPanel: true,
            beforeShow: function (input, inst) {
                setTimeout(function () {
                    $(inst.dpDiv).find('.ui-datepicker-month').hide();
                    $(inst.dpDiv).find('.ui-datepicker-calendar').hide();
                    $('.ui-datepicker-close').off('click').on('click', function () {
                        var year = $(input).datepicker('widget').find('.ui-datepicker-year :selected').val();
                        $(input).val(year);
                        $(input).datepicker('hide');
                    });
                }, 1);
            },
            onChangeMonthYear: function (year, month, inst) {
                setTimeout(function () {
                    $(inst.dpDiv).find('.ui-datepicker-month').hide();
                    $(inst.dpDiv).find('.ui-datepicker-calendar').hide();
                }, 1);
            },
            onClose: function (dateText, inst) {
                var year = $(this).datepicker('widget').find('.ui-datepicker-year :selected').val();
                if (year) $(this).val(year);
            }
        });
        // Icon click opens datepicker for this row
        $(newRow).find('.tyIcon').on('click', function () {
            $(this).siblings('.training-year').datepicker('show');
        });
    }

    // Add event listener to the initial add button
    trainingTableBody.querySelector('button.btn.btn-primary').addEventListener('click', function (e) {
        e.preventDefault();
        window.addTrainingRow();
    });

    // Initialize year-only datepicker for existing row
    $('#training-table-body .training-year').datepicker({
        dateFormat: "yy",
        changeMonth: false,
        changeYear: true,
        yearRange: "1950:2025",
        maxDate: 0,
        showButtonPanel: true,
        beforeShow: function (input, inst) {
            setTimeout(function () {
                $(inst.dpDiv).find('.ui-datepicker-month').hide();
                $(inst.dpDiv).find('.ui-datepicker-calendar').hide();
                $('.ui-datepicker-close').off('click').on('click', function () {
                    var year = $(input).datepicker('widget').find('.ui-datepicker-year :selected').val();
                    $(input).val(year);
                    $(input).datepicker('hide');
                });
            }, 1);
        },
        onChangeMonthYear: function (year, month, inst) {
            setTimeout(function () {
                $(inst.dpDiv).find('.ui-datepicker-month').hide();
                $(inst.dpDiv).find('.ui-datepicker-calendar').hide();
            }, 1);
        },
        onClose: function (dateText, inst) {
            var year = $(this).datepicker('widget').find('.ui-datepicker-year :selected').val();
            if (year) $(this).val(year);
        }
    });
    // Icon click for existing row
    $('#training-table-body .tyIcon').on('click', function () {
        $(this).siblings('.training-year').datepicker('show');
    });
});

/**
 * Profile Photo Cropper Logic
 * - Shows a modal with Cropper.js when a user selects an image.
 * - Allows cropping to a square aspect ratio.
 * - Stores the cropped image as a base64 string in a hidden input.
 */

let cropper = null;

// DOM elements
const fileInput = document.getElementById('profile-photo');
const cropperImage = document.getElementById('cropper-image');
const previewWrapper = document.getElementById('photo-preview-wrapper');
const previewImage = document.getElementById('photo-preview');
const cropConfirmBtn = document.getElementById('cropConfirmBtn');
const croppedImageInput = document.getElementById('cropped-image');

// Wait for face-api.js to load
Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('/face-api/weights'),
]).then(function () {
    // Ready for face detection
});

// Handle file input change
fileInput.addEventListener('change', async function (e) {
    const file = e.target.files[0];
    if (file && file.type.startsWith('image/')) {
        // Remove previous error if any
        let errorDiv = document.getElementById('photo-face-error');
        if (errorDiv) errorDiv.remove();
        fileInput.classList.remove('is-invalid');
        // Read image as data URL
        const reader = new FileReader();
        reader.onload = async function (event) {
            // Resize image to 300x300 before face detection and cropping
            const img = new window.Image();
            img.onload = async function () {
                // Create a canvas to resize
                const canvas = document.createElement('canvas');
                canvas.width = 300;
                canvas.height = 300;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, 300, 300);
                const resizedDataUrl = canvas.toDataURL('image/png');
                cropperImage.src = resizedDataUrl;
                cropperImage.onload = async function () {
                    // Wait for face-api.js to be ready
                    if (typeof faceapi === 'undefined' || !faceapi.nets.tinyFaceDetector.params) {
                        setTimeout(() => cropperImage.onload(), 200);
                        return;
                    }
                    // Detect face
                    const detections = await faceapi.detectAllFaces(cropperImage, new faceapi.TinyFaceDetectorOptions());
                    if (!detections || detections.length === 0) {
                        fileInput.value = '';
                        fileInput.classList.add('is-invalid');
                        const error = document.createElement('div');
                        error.id = 'photo-face-error';
                        error.className = 'invalid-feedback d-block';
                        error.innerText = 'Face not found in the selected image.';
                        fileInput.parentNode.appendChild(error);
                        return;
                    }
                    // Show Bootstrap modal for cropping
                    const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
                    modal.show();
                    modal._element.addEventListener('shown.bs.modal', () => {
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 1,        // Square crop
                            viewMode: 1,
                            autoCropArea: 1
                        });
                    }, { once: true });
                };
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Handle crop confirmation
cropConfirmBtn.addEventListener('click', () => {
    if (cropper) {
        // Get cropped image as a 200x200 PNG data URL
        const canvas = cropper.getCroppedCanvas({ width: 200, height: 200 });
        const dataUrl = canvas.toDataURL('image/png');
        previewImage.src = dataUrl;
        previewWrapper.style.display = 'block'; // Show preview only after cropping
        croppedImageInput.value = dataUrl;

        // Hide modal
        const modalElement = document.getElementById('cropperModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        modal.hide();
    }
});

// NID/BID toggle logic and validation
const nidRadio = document.getElementById('nidRadio');
const bidRadio = document.getElementById('bidRadio');
const nidInputGroup = document.getElementById('nid-input-group');
const bidInputGroup = document.getElementById('bid-input-group');
const identityError = document.getElementById('identity-error');
const nidNumberError = document.getElementById('nid-number-error');
const bidNumberError = document.getElementById('bid-number-error');
const nidNumberInput = document.getElementById('nid-number');
const bidNumberInput = document.getElementById('bid-number');

function toggleInputs() {
    if (nidRadio.checked) {
        nidInputGroup.classList.remove('d-none');
        bidInputGroup.classList.add('d-none');
    } else if (bidRadio.checked) {
        bidInputGroup.classList.remove('d-none');
        nidInputGroup.classList.add('d-none');
    } else {
        nidInputGroup.classList.add('d-none');
        bidInputGroup.classList.add('d-none');
    }
    // Hide only the radio error on toggle
    identityError.style.display = 'none';
    // Do NOT hide the input errors here, so they only show on Next
}
nidRadio.addEventListener('change', toggleInputs);
bidRadio.addEventListener('change', toggleInputs);
// Hide both on load
toggleInputs();

// Identity validation logic (only on Next/page change)
function validateIdentityField() {
    let valid = true;
    identityError.style.display = 'none';
    nidNumberError.style.display = 'none';
    bidNumberError.style.display = 'none';
    nidNumberInput.classList.remove('is-invalid');
    bidNumberInput.classList.remove('is-invalid');

    if (!nidRadio.checked && !bidRadio.checked) {
        identityError.textContent = 'Please select either NID or BID.';
        identityError.style.display = 'block';
        valid = false;
    } else if (nidRadio.checked) {
        if (!nidNumberInput.value.trim()) {
            nidNumberError.textContent = 'Please enter your NID number.';
            nidNumberError.style.display = 'block';
            nidNumberInput.classList.add('is-invalid');
            valid = false;
        }
    } else if (bidRadio.checked) {
        if (!bidNumberInput.value.trim()) {
            bidNumberError.textContent = 'Please enter your BID number.';
            bidNumberError.style.display = 'block';
            bidNumberInput.classList.add('is-invalid');
            valid = false;
        }
    }
    return valid;
}

function validateStep1() {
    let valid = true;
    const requiredFieldsStep1 = [
        { id: 'name', label: 'Name' },
        { id: 'father-name', label: 'Father Name' },
        { id: 'mother-name', label: 'Mother Name' },
        { id: 'phone-number', label: 'Phone Number' },
        { id: 'email', label: 'Email' },
        { id: 'category', label: 'Category', type: 'select' },
        { id: 'nidRadio', label: 'Identity NID', type: 'radio' },
        { id: 'bidRadio', label: 'Identity BID', type: 'radio' }
    ];
    let identityChecked = false;
    requiredFieldsStep1.forEach(field => {
        if (field.type === 'select') {
            const input = document.getElementById(field.id);
            if (input && !input.value) {
                input.classList.add('is-invalid');
                if (valid) input.focus();
                valid = false;
            } else if (input) {
                input.classList.remove('is-invalid');
            }
        } else if (field.type === 'radio') {
            const radio = document.getElementById(field.id);
            if (radio && radio.checked) identityChecked = true;
        } else {
            const input = document.getElementById(field.id);
            if (input && !input.value.trim()) {
                input.classList.add('is-invalid');
                if (valid) input.focus();
                valid = false;
            } else if (input) {
                input.classList.remove('is-invalid');
            }
            // Email validation (force check even if not empty)
            if (field.id === 'email' && input) {
                const emailVal = input.value.trim();
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const emailError = document.getElementById('email-error');
                if (!emailPattern.test(emailVal)) {
                    input.classList.add('is-invalid');
                    if (valid) input.focus();
                    valid = false;
                    if (emailError) emailError.style.display = 'block';
                } else {
                    input.classList.remove('is-invalid');
                    if (emailError) emailError.style.display = 'none';
                }
            }
        }
    });
    // At least one identity radio must be checked
    if (!identityChecked) {
        document.getElementById('nidRadio').classList.add('is-invalid');
        document.getElementById('bidRadio').classList.add('is-invalid');
        valid = false;
    } else {
        document.getElementById('nidRadio').classList.remove('is-invalid');
        document.getElementById('bidRadio').classList.remove('is-invalid');
    }
    // If NID or BID is selected, require the corresponding number
    if (document.getElementById('nidRadio').checked) {
        const nidInput = document.getElementById('nid-number');
        if (!nidInput.value.trim()) {
            nidInput.classList.add('is-invalid');
            nidInput.focus();
            valid = false;
        } else {
            nidInput.classList.remove('is-invalid');
        }
    }
    if (document.getElementById('bidRadio').checked) {
        const bidInput = document.getElementById('bid-number');
        if (!bidInput.value.trim()) {
            bidInput.classList.add('is-invalid');
            bidInput.focus();
            valid = false;
        } else {
            bidInput.classList.remove('is-invalid');
        }
    }
    // Phone validation (Bangladeshi number)
    if (iti) {
        const number = iti.getNumber();
        const bdPattern = /^\+8801[3-9]\d{8}$/;
        if (!bdPattern.test(number)) {
            phoneInput.classList.add("is-invalid");
            phoneError.style.display = "block";
            phoneInput.focus();
            valid = false;
        } else {
            phoneInput.classList.remove("is-invalid");
            phoneError.style.display = "none";
        }
    }
    // Identity validation (radio + number)
    if (!validateIdentityField()) valid = false;
    return valid;
}

// Validation for Step 2 (Academic): At least one row must have all fields filled
function validateStep2() {
    const rows = document.querySelectorAll('#academic-rows tr');
    let valid = false;
    let firstInvalidRow = null;
    rows.forEach(row => {
        const inputs = row.querySelectorAll('input');
        let allFilled = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                allFilled = false;
            }
        });
        if (allFilled) valid = true;
        if (!allFilled && !firstInvalidRow) firstInvalidRow = row;
    });
    // Only mark invalid if no row is fully filled
    if (!valid && firstInvalidRow) {
        firstInvalidRow.querySelectorAll('input').forEach(input => {
            if (!input.value.trim()) input.classList.add('is-invalid');
        });
        // Remove is-invalid from other rows
        rows.forEach(row => {
            if (row !== firstInvalidRow) {
                row.querySelectorAll('input').forEach(input => input.classList.remove('is-invalid'));
            }
        });
    } else {
        // Remove is-invalid from all rows if at least one is filled
        rows.forEach(row => {
            row.querySelectorAll('input').forEach(input => input.classList.remove('is-invalid'));
        });
    }
    if (!validateCgpaFields()) valid = false;
    return valid;
}

// Validation for Step 3 (Experience): At least one row must have all fields filled
function validateStep3() {
    const rows = document.querySelectorAll('#experience-table-body tr');
    let valid = false;
    let firstInvalidRow = null;
    rows.forEach(row => {
        const inputs = row.querySelectorAll('input');
        let allFilled = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                allFilled = false;
            }
        });
        if (allFilled) valid = true;
        if (!allFilled && !firstInvalidRow) firstInvalidRow = row;
    });
    if (!valid && firstInvalidRow) {
        firstInvalidRow.querySelectorAll('input').forEach(input => {
            if (!input.value.trim()) input.classList.add('is-invalid');
        });
        rows.forEach(row => {
            if (row !== firstInvalidRow) {
                row.querySelectorAll('input').forEach(input => input.classList.remove('is-invalid'));
            }
        });
    } else {
        rows.forEach(row => {
            row.querySelectorAll('input').forEach(input => input.classList.remove('is-invalid'));
        });
    }
    if (!validateExperienceDates()) valid = false;
    return valid;
}

// Validation for Step 4 (Training): At least one row must have all fields filled
function validateStep4() {
    const rows = document.querySelectorAll('#training-table-body tr');
    let valid = false;
    let firstInvalidRow = null;
    rows.forEach(row => {
        const inputs = row.querySelectorAll('input');
        let allFilled = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                allFilled = false;
            }
        });
        if (allFilled) valid = true;
        if (!allFilled && !firstInvalidRow) firstInvalidRow = row;
    });
    if (!valid && firstInvalidRow) {
        firstInvalidRow.querySelectorAll('input').forEach(input => {
            if (!input.value.trim()) input.classList.add('is-invalid');
        });
        rows.forEach(row => {
            if (row !== firstInvalidRow) {
                row.querySelectorAll('input').forEach(input => input.classList.remove('is-invalid'));
            }
        });
    } else {
        rows.forEach(row => {
            row.querySelectorAll('input').forEach(input => input.classList.remove('is-invalid'));
        });
    }
    return valid;
}

// CGPA validation (must be <= 5)
function validateCgpaFields() {
    let hasError = false;
    let cgpaInputs = document.querySelectorAll('#academic-rows input[placeholder="Enter CGPA"]');
    cgpaInputs.forEach(function (input) {
        if (input.value && parseFloat(input.value) > 5) {
            hasError = true;
        }
    });
    const cgpaError = document.getElementById('cgpa-error');
    if (hasError) {
        cgpaError.textContent = 'CGPA must be less than or equal to 5.';
        cgpaError.style.display = 'block';
    } else {
        cgpaError.textContent = '';
        cgpaError.style.display = 'none';
    }
    return !hasError;
}

// Experience date validation (end date >= start date)
function validateExperienceDates() {
    let hasError = false;
    let errorMsg = '';
    let rows = document.querySelectorAll('#experience-table-body tr');
    rows.forEach(function (row) {
        let start = row.querySelector('.start-date');
        let end = row.querySelector('.end-date');
        if (start && end && start.value && end.value) {
            let startDate = new Date(start.value);
            let endDate = new Date(end.value);
            if (endDate < startDate) {
                hasError = true;
            }
        }
    });
    const expError = document.getElementById('experience-date-error');
    if (hasError) {
        expError.textContent = 'End date cannot be before start date.';
        expError.style.display = 'block';
    } else {
        expError.textContent = '';
        expError.style.display = 'none';
    }
    return !hasError;
}

// CGPA input event: hide error on change if fixed
document.addEventListener('input', function (e) {
    if (e.target && e.target.placeholder === 'Enter CGPA') {
        validateCgpaFields();
    }
});

// Experience date input event: hide error on change if fixed
document.addEventListener('change', function (e) {
    if (e.target && (e.target.classList.contains('start-date') || e.target.classList.contains('end-date'))) {
        validateExperienceDates();
    }
});

// jQuery UI Datepicker for DOB
$(function () {

    $("#dob").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: "1900:2025",
        maxDate: 0
    });

    // Open datepicker when icon is clicked
    $("#dobIcon").on("click", function () {
        $("#dob").datepicker("show");
    });

    $(function () {
        $("#ps").datepicker({
            dateFormat: "yy",
            changeMonth: false,
            changeYear: true,
            yearRange: "1900:2025",
            maxDate: 0
        });

        // Open datepicker when icon is clicked
        $("#psIcon").on("click", function () {
            $("#ps").datepicker("show");
        });
    });


});

$(function () {
    function calculateYearsAndMonths() {
        const start = new Date($('#start-date').val());
        const end = new Date($('#end-date').val());

        if (!isNaN(start) && !isNaN(end) && end >= start) {
            // Calculate difference in milliseconds
            const diffTime = end - start;

            // Calculate total years (decimal)
            const diffYears = diffTime / (1000 * 60 * 60 * 24 * 365.25);
            $('#total-years').val(diffYears.toFixed(1));

            // Calculate full months
            let months;
            months = (end.getFullYear() - start.getFullYear()) * 12;
            months -= start.getMonth();
            months += end.getMonth();

            // Adjust for days in partial month
            if (end.getDate() < start.getDate()) {
                months -= 1;
            }

            $('#total-months').val(months);
        } else {
            $('#total-years').val('');
            $('#total-months').val('');
        }
    }

    $("#start-date, #end-date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: "1950:2050",
        onSelect: calculateYearsAndMonths
    });

    $('#start-date, #end-date').on('change', calculateYearsAndMonths);
});

$(document).on('click', '.calendar-icon', function () {
    // Find the input just before the icon in the same input-group
    $(this).siblings('input').datepicker('show');
});

// Limit CGPA max 5
// Add event listener to all CGPA inputs (including dynamically added rows)
document.addEventListener('input', function (e) {
    if (e.target && e.target.placeholder === 'Enter CGPA') {
        let val = parseFloat(e.target.value);
        if (val > 5) {
            e.target.value = 5;
        }
        if (val < 0) {
            e.target.value = 0;
        }
    }
});

// CSRF Token setup for AJAX
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Handle form submission with AJAX for file upload
$('#multiStepForm').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    // Collect Academic Info
    var academicRows = document.querySelectorAll('#academic-rows tr');
    var academicInfo = [];
    academicRows.forEach(function (row) {
        var inputs = row.querySelectorAll('input');
        if (inputs.length === 5) {
            academicInfo.push({
                education_level: inputs[0].value,
                department: inputs[1].value,
                institute_name: inputs[2].value,
                passing_year: inputs[3].value,
                cgpa: inputs[4].value
            });
        }
    });
    formData.append('academic_info', JSON.stringify(academicInfo));
    // Collect Experience Info
    var expRows = document.querySelectorAll('#experience-table-body tr');
    var experienceInfo = [];
    expRows.forEach(function (row) {
        var inputs = row.querySelectorAll('input');
        // Fix: Only push if at least one field is filled (not all empty)
        var hasData = Array.from(inputs).some(input => input.value.trim() !== '');
        if (inputs.length === 6 && hasData) {
            experienceInfo.push({
                company_name: inputs[0].value,
                designation: inputs[1].value,
                location: inputs[2].value,
                start_date: inputs[3].value,
                end_date: inputs[4].value,
                total_years: inputs[5] ? inputs[5].value : null
            });
        }
    });
    formData.append('experience_info', JSON.stringify(experienceInfo));
    // Collect Training Info
    var trainRows = document.querySelectorAll('#training-table-body tr');
    var trainingInfo = [];
    trainRows.forEach(function (row) {
        var inputs = row.querySelectorAll('input');
        var hasData = Array.from(inputs).some(input => input.value.trim() !== '');
        if (inputs.length === 5 && hasData) {
            trainingInfo.push({
                training_title: inputs[0].value,
                institute_name: inputs[1].value,
                duration: inputs[2].value,
                training_year: inputs[3].value,
                location: inputs[4].value
            });
        }
    });
    formData.append('training_info', JSON.stringify(trainingInfo));
    // Optionally, add extra validation here
    $.ajax({
        type: 'POST',
        url: '/upload',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            // Show success message or redirect
            alert('Form and files uploaded successfully!');
            location.reload(); // Reload the page
            // Optionally reload or redirect
        },
        error: function (xhr) {
            let errorDiv = document.getElementById('backend-errors');
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                let html = '<ul class="mb-0">';
                Object.values(xhr.responseJSON.errors).forEach(function (msgArr) {
                    msgArr.forEach(function (msg) {
                        html += '<li>' + msg + '</li>';
                    });
                });
                html += '</ul>';
                errorDiv.innerHTML = html;
                errorDiv.classList.remove('d-none');
                window.scrollTo({ top: errorDiv.offsetTop - 30, behavior: 'smooth' });
            } else {
                errorDiv.innerHTML = xhr.responseJSON?.message || 'Upload failed';
                errorDiv.classList.remove('d-none');
            }
        }
    });
});

// Save as Draft handler
$('.save-draft-btn').on('click', function (e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById('multiStepForm'));
    formData.append('is_draft', '-1');

    // Collect Academic Info
    var academicRows = document.querySelectorAll('#academic-rows tr');
    var academicInfo = [];
    academicRows.forEach(function (row) {
        var inputs = row.querySelectorAll('input');
        if (inputs.length === 5) {
            academicInfo.push({
                education_level: inputs[0].value,
                department: inputs[1].value,
                institute_name: inputs[2].value,
                passing_year: inputs[3].value,
                cgpa: inputs[4].value
            });
        }
    });
    formData.append('academic_info', JSON.stringify(academicInfo));
    // Collect Experience Info
    var expRows = document.querySelectorAll('#experience-table-body tr');
    var experienceInfo = [];
    expRows.forEach(function (row) {
        var inputs = row.querySelectorAll('input');
        // Fix: Only push if at least one field is filled (not all empty)
        // var hasData = Array.from(inputs).some(input => input.value.trim() !== '');
        if (inputs.length === 6 ) {
            experienceInfo.push({
                company_name: inputs[0].value,
                designation: inputs[1].value,
                location: inputs[2].value,
                start_date: inputs[3].value,
                end_date: inputs[4].value,
                total_years: inputs[5] ? inputs[5].value : null
            });
        }
    });
    formData.append('experience_info', JSON.stringify(experienceInfo));
    // Collect Training Info
    var trainRows = document.querySelectorAll('#training-table-body tr');
    var trainingInfo = [];
    trainRows.forEach(function (row) {
        var inputs = row.querySelectorAll('input');
        // var hasData = Array.from(inputs).some(input => input.value.trim() !== '');
        if (inputs.length === 5 ) {
            trainingInfo.push({
                training_title: inputs[0].value,
                institute_name: inputs[1].value,
                duration: inputs[2].value,
                training_year: inputs[3].value,
                location: inputs[4].value
            });
        }
    });
    formData.append('training_info', JSON.stringify(trainingInfo));

    $.ajax({
        url: '/forms',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            alert('Draft saved!');
        },
        error: function (xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                $('#backend-errors').removeClass('d-none').html(Object.values(xhr.responseJSON.errors).join('<br>'));
            } else {
                // print the error message inside aleart 
                console.error(xhr);
                alert('Error saving draft.');
            }
        }
    });
});

// Covid Certificate validation (PDF only, max 2MB)
const covidInput = document.getElementById('covid-certificate');
if (covidInput) {
    covidInput.addEventListener('change', function () {
        const file = this.files[0];
        let errorMsg = '';
        // Remove previous error if any
        this.classList.remove('is-invalid');
        let errorDiv = document.getElementById('covid-certificate-error');
        if (errorDiv) errorDiv.remove();
        if (file) {
            if (file.type !== 'application/pdf') {
                errorMsg = 'Only PDF files are allowed.';
            } else if (file.size > 2 * 1024 * 1024) {
                errorMsg = 'File size must be less than 2MB.';
            }
            if (errorMsg) {
                this.value = '';
                this.classList.add('is-invalid');
                const error = document.createElement('div');
                error.id = 'covid-certificate-error';
                error.className = 'invalid-feedback d-block';
                error.innerText = errorMsg;
                this.parentNode.appendChild(error);
            }
        }
    });
}

