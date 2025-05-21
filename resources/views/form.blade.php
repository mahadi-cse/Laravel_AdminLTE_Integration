@extends ('layouts.master')

@section('title', 'Step JS Form')

@php($hideHeader = false)
@php($hideBreadcrumb = true)

@section('content')
 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Multi-Step Form</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- TinyMCE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.0/tinymce.min.js"></script>

    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Face-api.js -->
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            tinymce.init({
                selector: '#editor, #editor-academic',
                height: 300,
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | removeformat | help'
            });
        });
    </script>
    <style>
        .iti {
            width: 100%;
        }

        .iti input {
            width: 100%;
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: flex !important;
            /* This is KEY: Bootstrap's `.row` uses `display: flex` */
            flex-wrap: wrap;
        }

        label {
            font-weight: 500;
        }


        #editor {
            z-index: -1;
        }

        /* Ensure datepicker appears above TinyMCE dialogs */
        .ui-datepicker {
            z-index: 2051 !important;
        }

        /* Overwrite Select2 single select to match Bootstrap form-control */
         .select2-container--default .select2-selection--single {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        .select2-container--default .select2-selection--single:focus {
            border-color: #86b7fe;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #212529;
            line-height: 1.5;
            padding-left: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: 10px;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d;
        }
        .select2-container {
            width: 100% !important;
        } 
       
    </style>
</head>

<body class="bg-light p-4">
    <div class="container">

        <!-- Step Buttons -->
        <nav class="row g-2 w-100 mb-4">
            <div class="col-12 col-sm-3">
                <button class="step-button btn btn-primary w-100 fw-semibold py-3" data-step="1">1. Personal
                    Information</button>
            </div>
            <div class="col-12 col-sm-3">
                <button class="step-button btn btn-outline-secondary w-100 fw-semibold py-3" data-step="2">2. Academic
                    Information</button>
            </div>
            <div class="col-12 col-sm-3">
                <button class="step-button btn btn-outline-secondary w-100 fw-semibold py-3" data-step="3">3.
                    Experience</button>
            </div>
            <div class="col-12 col-sm-3">
                <button class="step-button btn btn-outline-secondary w-100 fw-semibold py-3" data-step="4">4. Training
                    and Certification</button>
            </div>
        </nav>

        <!-- Multi-Step Form -->
        <form id="multiStepForm">

            <!-- STEP 1 -->
            <div class="step-content active row g-3" data-step="1">

                <!-- Profile Photo -->
                <div class="col-md-6">
                    <label class="form-label" style="width: 160px;" for="profile-photo">Profile Photo</label>

                    <!-- Flex container to align input and preview side by side -->
                    <div class="d-flex align-items-start gap-3">
                        <div class="flex-grow-1">
                            <input class="form-control" id="profile-photo" name="profile-photo" type="file"
                                accept="image/*" />
                            <input type="hidden" name="cropped-image" id="cropped-image" />
                        </div>

                        <!-- Image Preview to the right of the input -->
                        <div id="photo-preview-wrapper" style="display:none;">
                            <img id="photo-preview" src="#" alt="Preview" class="rounded border"
                                style="max-width: 120px; max-height: 120px;" />
                        </div>
                    </div>
                </div>


                <!-- Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required
                        placeholder="Enter your Name">
                </div>

                <!-- Father Name -->
                <div class="col-md-6">
                    <label for="father-name" class="form-label">Father Name <span class="text-danger">*</span></label>
                    <input type="text" placeholder="Enter your Father name" class="form-control" id="father-name"
                        name="father-name" required>
                </div>


                <!-- Mother Name -->
                <div class="col-md-6">
                    <label class="form-label " style="width: 160px;" for="mother-name">Mother Name
                        <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="mother-name" name="mother-name"
                        placeholder="Enter your Mother Name">
                </div>

                <!-- Phone Number -->
                <div class="col-md-6">
                    <label class="form-label " style="width: 160px;" for="phone-number">Phone
                        Number<span class="text-danger">*</span></label>
                    <div class="flex-grow-1 position-relative">
                        <input type="tel" class="form-control" id="phone-number" name="phone-number"
                            placeholder="Enter your Phone Number">
                        <div class="invalid-feedback" id="phone-error">Please enter a valid Bangladeshi phone number.
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label " style="width: 160px;" for="email">Email <span
                            class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter your Email Address">
                    <span id="email-error" class="text-danger" style="display:none; font-size: 0.95em;">Please enter a valid email address.</span>
                </div>

                <!-- Present Address -->
                <div class="col-md-6">
                    <label class="form-label " style="width: 160px;" for="present-address">Present
                        Address</label>
                    <input type="text" class="form-control" id="present-address" name="present-address"
                        placeholder="Enter your Present Address">
                </div>

                <!-- Permanent Address -->
                <div class="col-md-6">
                    <label class="form-label " style="width: 160px;" for="permanent-address">Permanent
                        Address</label>
                    <input type="text" class="form-control" id="permanent-address" name="permanent-address"
                        placeholder="Enter your Permanent Address">
                </div>

                <!-- Nationality -->
                <div class="col-md-6">
                    <label class="form-label" for="nationality">Nationality</label>
                    <select class="form-control" id="nationality" name="nationality" style="width: 100%;">
                        <option value="" disabled selected>Select your nationality</option>
                    </select>
                </div>


                <!-- Hobby -->
                <div class="col-md-6">
                    <label class="form-label" for="hobby">Hobby</label>
                    <select class="form-control select2" id="hobby" name="hobby" >
                           <option value="" disabled selected>Select your hobby</option> 
                    </select>
                </div>

                <!-- Date of Birth -->
                <div class="col-md-6">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <div class="input-group">
                        <input type="text" placeholder="Enter birth date" class="form-control" id="dob" name="dob"
                            autocomplete="off">
                        <span class="input-group-text" id="dobIcon" style="cursor: pointer;">
                            <i class="bi bi-calendar"></i> <!-- Bootstrap Icons -->
                        </span>
                    </div>
                </div>


                <!-- Gender -->
                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="" disabled selected>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Identity <span class="text-danger">*</span></label>
                    <div class="gap-3">
                        <!-- Radio section -->
                        <div style=" width: 50%;">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="identityType" id="nidRadio"
                                    value="nid">
                                <label class="form-check-label" for="nidRadio">NID</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="identityType" id="bidRadio"
                                    value="bid">
                                <label class="form-check-label" for="bidRadio">BID</label>
                            </div>
                        </div>

                        <!-- Input field section -->
                        <div class="mt-4">
                            <!-- NID -->
                            <div id="nid-input-group" class="align-items-center mb-2 d-none">
                                <label for="nid-number" class="form-label me-2 mb-0" style="white-space: nowrap;">NID
                                    Number</label>
                                <input type="number" class="form-control" id="nid-number" name="nid-number"
                                    placeholder="Enter NID">
                            </div>
                            <!-- BID -->
                            <div id="bid-input-group" class="align-items-center d-none">
                                <label for="bid-number" class="form-label me-2 mb-0" style="white-space: nowrap;">BID
                                    Number</label>
                                <input type="number" class="form-control" id="bid-number" name="bid-number"
                                    placeholder="Enter BID">
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <label for="covid-certificate" class="form-label">Covid Certificate</label>
                    <input type="file" class="form-control" id="covid-certificate" name="covid-certificate" 
                        accept=".pdf,application/pdf">
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="editor" name="description" rows="3"></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary">Save as Draft</button>
                    <div>
                        <!-- <button type="button" class="btn btn-outline-secondary" disabled>Previous</button> -->
                        <button type="button" class="btn btn-primary next-btn">Next</button>
                    </div>
                </div>

            </div>
            <!-- STEP 2 -->
            <div class="step-content" data-step="2">
                <div class="table-responsive" style="width: 100%;">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Education Level</th>
                                <th>Department</th>
                                <th>Institute Name</th>
                                <th>Passing Year</th>
                                <th>CGPA</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="academic-rows">
                            <tr>
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
                                    <input type="number" class="form-control" placeholder="Enter Passing Year">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="Enter CGPA">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary add-academic-row">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="button_container" style="
                    display: flex;
                    justify-content: space-between;
                    width: 100%;">
                    <button type="button" class="btn btn-secondary">Save as Draft</button>
                    <div>
                        <button class="btn btn-primary prev-btn" type="button">Previous</button>
                        <button class="btn btn-primary next-btn" type="button">Next</button>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="step-content" data-step="3" style="width: 100%;">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Company Name</th>
                                <th>Designation</th>
                                <th>Location</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Total Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="experience-table-body">
                            <tr>
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
                                        <input type="text" class="form-control start-date" id="start-date"
                                            placeholder="Start Date" autocomplete="off">
                                        <span class="input-group-text calendar-icon" style="cursor: pointer;">
                                            <i class="bi bi-calendar"></i> <!-- Bootstrap Icons -->
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control end-date" id="end-date"
                                            placeholder="End Date" autocomplete="off">
                                        <span class="input-group-text calendar-icon" style="cursor: pointer;">
                                            <i class="bi bi-calendar"></i> <!-- Bootstrap Icons -->
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" class="form-control total-years" id="total-years"
                                        placeholder="Years" readonly>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary add-experience-row">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="button_container" style="
                    display: flex;
                    justify-content: space-between;
                    width: 100%;">
                    <button type="button" class="btn btn-secondary">Save as Draft</button>
                    <div>
                        <button class="btn btn-primary prev-btn" type="button">Previous</button>
                        <button class="btn btn-primary next-btn" type="button">Next</button>
                    </div>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="step-content" data-step="4" style="width: 100%;">
                <div class="table-responsive" style="width: 100%;">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Training Title</th>
                                <th>Institute Name</th>
                                <th>Duration</th>
                                <th>Training Year</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="training-table-body">
                            <tr>
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
                                    <input type="text" class="form-control" placeholder="Enter Training Year">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Enter Location">
                                </td>
                                <td class="text-center">
                                    <button type="button" onclick="addTrainingRow()" class="btn btn-primary">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="button_container" style="
                    display: flex;
                    justify-content: space-between;
                    width: 100%;">
                    <button type="button" class="btn btn-secondary">Save as Draft</button>
                    <div>
                        <button class="btn btn-primary prev-btn" type="button">Previous</button>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </div>

            </div>
        </form>
    </div>


    <!-- Cropper modal -->
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Profile Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="cropper-image" src="" style="max-width: 100%;" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="cropConfirmBtn">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <!-- jQuery UI Datepicker -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch nationalities via AJAX
            $.ajax({
                url: '/nationalities',
                method: 'GET',
                success: function(data) {
                    var select = $('#nationality');
                    select.empty();
                    select.append('<option value="" disabled selected>Select your nationality</option>');
                    data.forEach(function(item) {
                        select.append('<option value="' + item.name + '">' + item.name + '</option>');
                    });
                    select.trigger('change');
                }
            });
            $('#nationality').select2({
                placeholder: 'Select your nationality',
                allowClear: true,
                width: '100%'
            });
            // Remove manual AJAX for hobbies, use only Select2 AJAX for hobby
            $('#hobby').select2({
                placeholder: 'Select your hobby',
            
                allowClear: true,
                width: '100%',
                ajax: {
                    url: '/hobbies',
                    dataType: 'json',
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function(data) {
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
                <input type="text" class="form-control" placeholder="Enter Passing Year">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Enter CGPA">
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
            }

            // Add event listener to the initial add button
            document.querySelector('.add-academic-row').addEventListener('click', addNewRow);
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

                // Add date change listeners to calculate duration
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

                startDateInput.addEventListener('change', updateYears);
                endDateInput.addEventListener('change', updateYears);
            }

            // Add event listener to the initial add button
            document.querySelector('.add-experience-row').addEventListener('click', addExperienceRow);

            // Setup datepickers and listeners for the first row
            $(experienceTableBody.querySelectorAll('.start-date, .end-date')).datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                yearRange: "1950:2025",
                maxDate: 0
            });
            setupDateListeners(experienceTableBody.querySelector('tr'));
        });

        // Add training row
        document.addEventListener('DOMContentLoaded', function () {
            const trainingTableBody = document.getElementById('training-table-body');

            // Function to add a new training row
            function addTrainingRow() {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
            <td>
                <input type="text" class="form-control" placeholder="Enter Training Title">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Enter Institute Name">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Enter Duration">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Enter Training Year">
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
            }

            // Add event listener to the initial add button
            trainingTableBody.querySelector('button.btn.btn-primary').addEventListener('click', function (e) {
                e.preventDefault();
                addTrainingRow();
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
        ]).then(function() {
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

        // NID/BID toggle logic
        const nidRadio = document.getElementById('nidRadio');
        const bidRadio = document.getElementById('bidRadio');
        const nidInputGroup = document.getElementById('nid-input-group');
        const bidInputGroup = document.getElementById('bid-input-group');

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
        }
        nidRadio.addEventListener('change', toggleInputs);
        bidRadio.addEventListener('change', toggleInputs);
        // Hide both on load
        toggleInputs();


        // Required fields for Step 1 (all fields except those without *)
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

        function validateStep1() {
            let valid = true;
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

        $(document).on('click', '.calendar-icon', function() {
            // Find the input just before the icon in the same input-group
            $(this).siblings('input').datepicker('show');
        });

        // Limit CGPA max 5
        // Add event listener to all CGPA inputs (including dynamically added rows)
        document.addEventListener('input', function(e) {
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
        $('#multiStepForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            // Optionally, add extra validation here
            $.ajax({
                type: 'POST',
                url: '/upload',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Show success message or redirect
                    alert('Form and files uploaded successfully!');
                    location.reload(); // Reload the page
                    // Optionally reload or redirect
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Upload failed');
                }
            });
        });

        // Covid Certificate validation (PDF only, max 2MB)
        const covidInput = document.getElementById('covid-certificate');
        if (covidInput) {
            covidInput.addEventListener('change', function() {
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
    </script>

</body>

</html>
@endsection