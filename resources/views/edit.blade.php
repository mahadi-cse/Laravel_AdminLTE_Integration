@extends ('layouts.master')

@section('title', 'Edit Form')

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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">


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
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
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

            <!-- Display backend validation errors -->
            <div id="backend-errors" class="alert alert-danger d-none"></div>
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
            <form id="multiStepForm" enctype="multipart/form-data">

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

                            @if(!empty($personalInfo->profile_photo_path) && $personalInfo->profile_photo_path !== 'http://127.0.0.1:8000/')
                                <div id="photo-preview-wrapper" style="display:none;">
                                    <img id="photo-preview" src="{{$personalInfo->profile_photo_path}}" alt="Preview"
                                        class="rounded border" style="max-width: 120px; max-height: 120px;" />
                                </div>
                            @endif
                            <!-- <p>{{$personalInfo->profile_photo_path ?? " "}}</p>
                                                                                                <p>{{$personalInfo->name ?? ''}}</p> -->
                        </div>
                    </div>


                    <!-- Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Name"
                            value="{{$personalInfo->name ?? ''}}" required>
                    </div>

                    <!-- Father Name -->
                    <div class="col-md-6">
                        <label for="father-name" class="form-label">Father Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="father-name" name="father-name"
                            placeholder="Enter your Father Name" value="{{$personalInfo->father_name ?? ''}}" required>
                    </div>


                    <!-- Mother Name -->
                    <div class="col-md-6">
                        <label class="form-label " style="width: 160px;" for="mother-name">Mother Name
                            <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mother-name" name="mother-name"
                            placeholder="Enter your Mother Name" value="{{$personalInfo->mother_name ?? ''}}">
                    </div>

                    <!-- Phone Number -->
                    <div class="col-md-6">
                        <label class="form-label " style="width: 160px;" for="phone-number">Phone
                            Number<span class="text-danger">*</span></label>
                        <div class="flex-grow-1 position-relative">
                            <input type="tel" class="form-control" id="phone-number" name="phone-number"
                                placeholder="Enter your Phone Number" value="{{$personalInfo->phone_number ?? ''}}">
                            <div class="invalid-feedback" id="phone-error">Please enter a valid Bangladeshi phone number.
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label " style="width: 160px;" for="email">Email <span
                                class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter your Email Address" value="{{$personalInfo->email ?? ''}}">
                        <span id="email-error" class="text-danger" style="display:none; font-size: 0.95em;">Please enter a
                            valid email address.</span>
                    </div>

                    <!-- Present Address -->
                    <div class="col-md-6">
                        <label class="form-label " style="width: 160px;" for="present-address">Present
                            Address</label>
                        <input type="text" class="form-control" id="present-address" name="present-address"
                            placeholder="Enter your Present Address" value="{{$personalInfo->present_address ?? ''}}">
                    </div>

                    <!-- Permanent Address -->
                    <div class="col-md-6">
                        <label class="form-label " style="width: 160px;" for="permanent-address">Permanent
                            Address</label>
                        <input type="text" class="form-control" id="permanent-address" name="permanent-address"
                            placeholder="Enter your Permanent Address" value="{{$personalInfo->permanent_address ?? ''}}">
                    </div>

                    <!-- Nationality -->
                    <div class="col-md-6">
                        <label class="form-label" for="nationality">Nationality</label>
                        <select class="form-control select2" id="nationality" name="nationality" style="width: 100%;">
                            <option value="" disabled selected>Select your nationality</option>
                        </select>
                    </div>


                    <!-- Hobby -->
                    <div class="col-md-6">
                        <label class="form-label" for="hobby">Hobby</label>
                        <select class="form-control select2" id="hobby" name="hobby">
                            <option value="" disabled selected>Select your hobby</option>
                        </select>
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <div class="input-group">
                            <input type="text" placeholder="Enter birth date" class="form-control" id="dob" name="dob"
                                autocomplete="off" value="{{$personalInfo->dob ?? ''}}">
                            <span class="input-group-text" id="dobIcon" style="cursor: pointer;">
                                <i class="bi bi-calendar"></i> <!-- Bootstrap Icons -->
                            </span>
                        </div>
                    </div>


                    <!-- Gender -->
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="" disabled {{ $personalInfo->gender ? '' : 'selected' }}>Select Gender</option>
                            <option value="male" {{ $personalInfo->gender === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $personalInfo->gender === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ $personalInfo->gender === 'other' ? 'selected' : '' }}>Other</option>
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
                            <div id="identity-error" class="text-danger mt-2" style="display:none; font-size:0.95em;"></div>
                            <!-- Input field section -->
                            <div class="mt-4">
                                <!-- NID -->
                                <div id="nid-input-group" class="align-items-center mb-2 d-none">
                                    <label for="nid-number" class="form-label me-2 mb-0" style="white-space: nowrap;">NID
                                        Number</label>
                                    <input type="number" class="form-control" id="nid-number" name="nid-number"
                                        placeholder="Enter NID">
                                    <div id="nid-number-error" class="text-danger mt-1"
                                        style="display:none; font-size:0.95em;"></div>
                                </div>
                                <!-- BID -->
                                <div id="bid-input-group" class="align-items-center d-none">
                                    <label for="bid-number" class="form-label me-2 mb-0" style="white-space: nowrap;">BID
                                        Number</label>
                                    <input type="number" class="form-control" id="bid-number" name="bid-number"
                                        placeholder="Enter BID">
                                    <div id="bid-number-error" class="text-danger mt-1"
                                        style="display:none; font-size:0.95em;"></div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <label for="covid-certificate" class="form-label">Covid Certificate</label>
                        <input type="file" class="form-control" id="covid-certificate" name="covid-certificate"
                            accept=".pdf,application/pdf">
                        <!-- <p>{{$personalInfo->covid_certificate_path}}</p> -->
                        <!-- <p>{{$personalInfo->covid_certificate_path}}</p> -->
                        @if(!empty($personalInfo->covid_certificate_path) && $personalInfo->covid_certificate_path !== 'http://127.0.0.1:8000/')
                            <a href="{{$personalInfo->covid_certificate_path}}">View Your Certificate</a>
                        @endif
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="editor" name="description" rows="3"></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary save-draft-btn">Save as Draft</button>
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
                                    <td><input type="text" class="form-control" placeholder="Enter Education Level"></td>
                                    <td><input type="text" class="form-control" placeholder="Enter Department"></td>
                                    <td><input type="text" class="form-control" placeholder="Enter Institute Name"></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control passing-year"
                                                placeholder="Enter Passing Year" autocomplete="off">
                                            <span class="input-group-text psIcon" style="cursor: pointer;">
                                                <i class="bi bi-calendar"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td><input type="number" class="form-control" placeholder="Enter CGPA"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary add-academic-row">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="cgpa-error" class="text-danger mt-1" style="display:none; font-size:0.95em;"></div>
                    </div>
                    <div class="button_container" style="
                                                                                            display: flex;
                                                                                            justify-content: space-between;
                                                                                            width: 100%;">
                        <button type="button" class="btn btn-secondary save-draft-btn">Save as Draft</button>
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
                        <div id="experience-date-error" class="text-danger mt-1" style="display:none; font-size:0.95em;">
                        </div>
                    </div>
                    <div class="button_container" style="
                                                                                            display: flex;
                                                                                            justify-content: space-between;
                                                                                            width: 100%;">
                        <button type="button" class="btn btn-secondary save-draft-btn">Save as Draft</button>
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
                                        <div class="input-group">
                                            <input type="text" class="form-control training-year"
                                                placeholder="Enter Training Year" autocomplete="off">
                                            <span class="input-group-text tyIcon" style="cursor: pointer;">
                                                <i class="bi bi-calendar"></i> <!-- Bootstrap Icons -->
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" placeholder="Enter Location">
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary">
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
                        <div>
                            <button type="button" class="btn btn-secondary save-draft-btn">Save as Draft</button>
                            <button type="button" class="btn btn-info ms-2" id="previewBtn">Preview</button>
                        </div>
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

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewModalLabel">Preview Your Application</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="previewContent">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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


        <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


        <script>

            $(document).ready(function () {
                $('#previewBtn').on('click', function () {
                    // Gather all form data
                    var form = $('#multiStepForm')[0];
                    var formData = new FormData(form);
                    // Helper to get value or fallback
                    function getVal(name) {
                        return formData.get(name) || '<span class="text-muted">(empty)</span>';
                    }
                    // Gender, Nationality, Hobby text
                    var gender = $('#gender option:selected').text();
                    var nationality = $('#nationality option:selected').text();
                    var hobby = $('#hobby option:selected').text();
                    // Identity
                    var identityType = $('input[name="identityType"]:checked').val();
                    var identityNumber = identityType === 'nid' ? getVal('nid-number') : (identityType === 'bid' ? getVal('bid-number') : '');
                    // Profile photo preview
                    var photoPreview = '';
                    if ($('#photo-preview').attr('src') && $('#photo-preview-wrapper').is(':visible')) {
                        photoPreview = `<img src="${$('#photo-preview').attr('src')}" style="max-width:100px;max-height:100px;" class="mb-2 rounded border" alt="Profile Photo" />`;
                    }
                    // Covid certificate file name or link
                    var covidFile = '';
                    if ($('#covid-certificate')[0].files[0]) {
                        covidFile = $('#covid-certificate')[0].files[0].name;
                    } else {
                        // Check if a valid covid_certificate_path exists from the backend
                        var covidCertificatePath = @json($personalInfo->covid_certificate_path ?? '');
                        if (covidCertificatePath && covidCertificatePath !== 'http://127.0.0.1:8000/') {
                            covidFile = `<a href="${covidCertificatePath}" target="_blank">View Your Certificate</a>`;
                        } else {
                            covidFile = '<span class="text-muted">(none)</span>';
                        }
                    }
                    // Academic, Experience, Training tables (just show first row for demo, can be extended)
                    function tableRows(selector) {
                        var rows = '';
                        $(selector + ' tr').each(function (i, tr) {
                            var tds = $(tr).find('td');
                            if (tds.length === 0) return;
                            // Only include row if at least one input/select has a value
                            var hasValue = false;
                            tds.each(function (i, td) {
                                // Skip the last td (Action column)
                                if (i === tds.length - 1) return;
                                var input = $(td).find('input, select');
                                rows += `<td>${input.length ? (input.val() || '<span class="text-muted">(empty)</span>') : $(td).text()}</td>`;
                            });
                            if (!hasValue) return; // skip empty/template row
                            rows += '<tr>';
                            tds.each(function (_, td) {
                                var input = $(td).find('input, select');
                                rows += `<td>${input.length ? (input.val() || '<span class="text-muted">(empty)</span>') : $(td).text()}</td>`;
                            });
                            rows += '</tr>';
                        });
                        return rows || '<tr><td colspan="6" class="text-center text-muted">No data</td></tr>';
                    }
                    // Build preview HTML
                    var html = `
                                            <div class="row mb-3">
                                                  <h4 style ="color : #3366cc" >Applicant Information</h4>
                                            </div>
                                          
                                            <div class="row g-3">
                                                <div class="col-md-6"><strong>Name:</strong> ${getVal('name')}</div>
                                                <div class="col-md-6"><strong>Father Name:</strong> ${getVal('father-name')}</div>
                                                <div class="col-md-6"><strong>Mother Name:</strong> ${getVal('mother-name')}</div>
                                                <div class="col-md-6"><strong>Phone Number:</strong> ${getVal('phone-number')}</div>
                                                <div class="col-md-6"><strong>Email:</strong> ${getVal('email')}</div>
                                                <div class="col-md-6"><strong>Present Address:</strong> ${getVal('present-address')}</div>
                                                <div class="col-md-6"><strong>Permanent Address:</strong> ${getVal('permanent-address')}</div>
                                                <div class="col-md-6"><strong>Nationality:</strong> ${nationality}</div>
                                                <div class="col-md-6"><strong>Hobby:</strong> ${hobby}</div>
                                                <div class="col-md-6"><strong>Date of Birth:</strong> ${getVal('dob')}</div>
                                                <div class="col-md-6"><strong>Gender:</strong> ${gender}</div>
                                                <div class="col-md-6"><strong>Identity Type:</strong> ${identityType ? identityType.toUpperCase() : '<span class=\'text-muted\'>(none)</span>'}</div>
                                                <div class="col-md-6"><strong>Identity Number:</strong> ${identityNumber}</div>
                                                <div class="col-md-6"><strong>Covid Certificate:</strong> ${covidFile}</div>
                                                <div class="col-12"><strong>Description:</strong> ${tinymce.get('editor') ? tinymce.get('editor').getContent({ format: 'text' }) : getVal('description')}</div>
                                            </div>
                                            <hr/>
                                            <h4 style ="color : #3366cc">Academic Information</h4>
                                            <div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Education Level</th><th>Department</th><th>Institute Name</th><th>Passing Year</th><th>CGPA</th></tr></thead><tbody>${tableRows('#academic-rows')}</tbody></table></div>
                                            <h4 class="mt-3" style ="color : #3366cc">Experience</h4>
                                            <div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Company Name</th><th>Designation</th><th>Location</th><th>Start Date</th><th>End Date</th><th>Total Year</th></tr></thead><tbody>${tableRows('#experience-table-body')}</tbody></table></div>
                                            <h4 class="mt-3" style ="color : #3366cc">Training & Certification</h4>
                                            <div class="table-responsive"><table class="table table-bordered"><thead><tr><th>Training Title</th><th>Institute Name</th><th>Duration</th><th>Training Year</th><th>Location</th></tr></thead><tbody>${tableRows('#training-table-body')}</tbody></table></div>
                                        `;
                    $('#previewContent').html(html);
                    var modal = new bootstrap.Modal(document.getElementById('previewModal'));
                    modal.show();
                });
            });

            document.addEventListener("DOMContentLoaded", () => {

                // academic section started

                // Clear the default row if we have data from database
                const academicRows = @json($academicInfo);
                const academicTableBody = document.getElementById('academic-rows');
                if (academicRows && academicRows.length > 0) {
                    academicTableBody.innerHTML = ''; // Clear the default row

                    // Add rows from database
                    academicRows.forEach((row, index) => {
                        const newRow = `<tr>
                                                                    <td><input type="text" class="form-control" value="${row.education_level}" placeholder="Enter Education Level"></td>
                                                                    <td><input type="text" class="form-control" value="${row.department}" placeholder="Enter Department"></td>
                                                                    <td><input type="text" class="form-control" value="${row.institute_name}" placeholder="Enter Institute Name"></td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control passing-year" value="${row.passing_year}" placeholder="Enter Passing Year">
                                                                            <span class="input-group-text psIcon" style="cursor: pointer;">
                                                                                <i class="bi bi-calendar"></i>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                    <td><input type="number" class="form-control" value="${row.cgpa}" placeholder="Enter CGPA"></td>
                                                                    <td class="text-center">
                                                                        <button type="button" class="${index === 0 ? 'btn btn-primary add-academic-row' : 'btn btn-danger remove-academic-row'}">
                                                                            <i class="fas fa-${index === 0 ? 'plus' : 'minus'}"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>`;
                        academicTableBody.insertAdjacentHTML('beforeend', newRow);
                    });

                    // Add an empty row with plus button at the end     // Always add an empty row with plus button if there are no database rows

                }

                // Function to add new academic row
                function addAcademicRow(event) {
                    const button = event.target.closest('button');
                    if (!button) return;

                    // Add new row with minus button (no need to change the first row's button)
                    const newRow = `<tr>
                                                                <td><input type="text" class="form-control" placeholder="Enter Education Level"></td>
                                                                <td><input type="text" class="form-control" placeholder="Enter Department"></td>
                                                                <td><input type="text" class="form-control" placeholder="Enter Institute Name"></td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control passing-year" placeholder="Enter Passing Year" autocomplete="off">
                                                                        <span class="input-group-text psIcon" style="cursor: pointer;">
                                                                            <i class="bi bi-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control" placeholder="Enter CGPA"></td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-danger remove-academic-row">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>`;
                    academicTableBody.insertAdjacentHTML('beforeend', newRow);

                    // Initialize datepicker for the new row
                    const lastRow = academicTableBody.lastElementChild;
                    const passingYear = lastRow.querySelector('.passing-year');

                    $(passingYear).datepicker({
                        dateFormat: "yy",
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
                }                // Event delegation for add/remove buttons
                academicTableBody.addEventListener('click', function (e) {
                    const button = e.target.closest('button');
                    if (!button) return;

                    if (button.classList.contains('add-academic-row')) {
                        addAcademicRow(); // Add new row with minus button at the bottom
                    } else if (button.classList.contains('remove-academic-row')) {
                        const row = button.closest('tr');
                        // Don't allow removing the first row which should have the plus button
                        if (row && row !== academicTableBody.firstElementChild) {
                            row.remove();
                        }
                    }
                });

                // Initialize datepicker for existing passing year fields
                document.querySelectorAll('.passing-year').forEach(input => {
                    $(input).datepicker({
                        dateFormat: "yy",
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
                });


                // academic section ended

                // experience section started

                // Clear the default row if we have data from database
                const experienceRows = @json($experienceInfo);
                const experienceTableBody = document.getElementById('experience-table-body');
                if (experienceRows && experienceRows.length > 0) {
                    experienceTableBody.innerHTML = '';
                    experienceRows.forEach((row, index) => {
                        const newRow = `<tr>
                                                                <td><input type="text" class="form-control" value="${row.company_name}" placeholder="Enter Company Name"></td>
                                                                <td><input type="text" class="form-control" value="${row.designation}" placeholder="Enter Designation"></td>
                                                                <td><input type="text" class="form-control" value="${row.location}" placeholder="Enter Location"></td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control start-date" placeholder="Start Date" autocomplete="off" value="${row.start_date}">
                                                                        <span class="input-group-text calendar-icon" style="cursor: pointer;">
                                                                            <i class="bi bi-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control end-date" placeholder="End Date" autocomplete="off" value="${row.end_date}">
                                                                        <span class="input-group-text calendar-icon" style="cursor: pointer;">
                                                                            <i class="bi bi-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control total-years" placeholder="Years" readonly value="${row.total_years}"></td>
                                                                <td class="text-center">
                                                                    <button type="button" class="${index === 0 ? 'btn btn-primary add-experience-row' : 'btn btn-danger remove-experience-row'}">
                                                                        <i class="fas fa-${index === 0 ? 'plus' : 'minus'}"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>`;
                        experienceTableBody.insertAdjacentHTML('beforeend', newRow);
                    });
                }

                // Function to add new experience row
                function addExperienceRow() {
                    const newRow = `<tr>
                                                                <td><input type="text" class="form-control" placeholder="Enter Company Name"></td>
                                                                <td><input type="text" class="form-control" placeholder="Enter Designation"></td>
                                                                <td><input type="text" class="form-control" placeholder="Enter Location"></td>
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
                                                                <td><input type="number" class="form-control total-years" placeholder="Years" readonly></td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-danger remove-experience-row">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>`;
                    experienceTableBody.insertAdjacentHTML('beforeend', newRow);
                    // Initialize datepickers and year calculation for the new row
                    const lastRow = experienceTableBody.lastElementChild;
                    const startDate = lastRow.querySelector('.start-date');
                    const endDate = lastRow.querySelector('.end-date');
                    $(startDate).datepicker({
                        dateFormat: "yy-mm-dd",
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "1950:2025",
                        maxDate: 0
                    });
                    $(endDate).datepicker({
                        dateFormat: "yy-mm-dd",
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "1950:2025",
                        maxDate: 0
                    });
                    setupDateListeners(lastRow);
                }

                // Event delegation for add/remove buttons
                experienceTableBody.addEventListener('click', function (e) {
                    const button = e.target.closest('button');
                    if (!button) return;
                    if (button.classList.contains('add-experience-row')) {
                        // addExperienceRow();
                    } else if (button.classList.contains('remove-experience-row')) {
                        const row = button.closest('tr');
                        if (row && row !== experienceTableBody.firstElementChild) {
                            row.remove();
                        }
                    }
                });

                // Initialize datepicker and year calculation for existing rows
                Array.from(experienceTableBody.children).forEach(row => {
                    const startDate = row.querySelector('.start-date');
                    const endDate = row.querySelector('.end-date');
                    $(startDate).datepicker({
                        dateFormat: "yy-mm-dd",
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "1950:2025",
                        maxDate: 0
                    });
                    $(endDate).datepicker({
                        dateFormat: "yy-mm-dd",
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "1950:2025",
                        maxDate: 0
                    });
                    setupDateListeners(row);
                });
                // experience section ended

                // training section started

                // Clear default row and populate from DB
                const trainingRows = @json($trainingInfo);
                const trainingTableBody = document.getElementById('training-table-body');

                if (trainingRows && trainingRows.length > 0) {
                    trainingTableBody.innerHTML = ''; // Clear default

                    trainingRows.forEach((row, index) => {
                        const newRow = `<tr>
                                                    <td><input type="text" class="form-control" value="${row.training_title}" placeholder="Enter Training Title"></td>
                                                    <td><input type="text" class="form-control" value="${row.institute_name}" placeholder="Enter Institute Name"></td>
                                                    <td><input type="number" class="form-control" value="${row.duration}" placeholder="Enter Duration"></td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control training-year" value="${row.training_year}" placeholder="Enter Training Year">
                                                            <span class="input-group-text tyIcon" style="cursor: pointer;">
                                                                <i class="bi bi-calendar"></i>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" class="form-control" value="${row.location}" placeholder="Enter Location"></td>
                                                    <td class="text-center">
                                                        <button type="button" class="${index === 0 ? 'btn btn-primary add-training-row' : 'btn btn-danger remove-training-row'}">
                                                            <i class="fas fa-${index === 0 ? 'plus' : 'minus'}"></i>
                                                        </button>
                                                    </td>
                                                </tr>`;
                        trainingTableBody.insertAdjacentHTML('beforeend', newRow);
                    });
                }

                // Function to add new training row
                function addTrainingRow() {
                    const newRow = `<tr>
                                                <td><input type="text" class="form-control" placeholder="Enter Training Title"></td>
                                                <td><input type="text" class="form-control" placeholder="Enter Institute Name"></td>
                                                <td><input type="number" class="form-control" placeholder="Enter Duration"></td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control training-year" placeholder="Enter Training Year" autocomplete="off">
                                                        <span class="input-group-text tyIcon" style="cursor: pointer;">
                                                            <i class="bi bi-calendar"></i>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td><input type="text" class="form-control" placeholder="Enter Location"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger remove-training-row">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>`;
                    trainingTableBody.insertAdjacentHTML('beforeend', newRow);

                    const lastRow = trainingTableBody.lastElementChild;
                    const trainingYear = lastRow.querySelector('.training-year');
                    initializeYearOnlyDatepicker(trainingYear);
                }

                // Event delegation for add/remove buttons
                trainingTableBody.addEventListener('click', function (e) {
                    const button = e.target.closest('button');
                    if (!button) return;

                    if (button.classList.contains('add-training-row')) {
                        // addTrainingRow();
                    } else if (button.classList.contains('remove-training-row')) {
                        const row = button.closest('tr');
                        if (row && row !== trainingTableBody.firstElementChild) {
                            row.remove();
                        }
                    }
                });

                // Reusable datepicker initializer
                function initializeYearOnlyDatepicker(input) {
                    $(input).datepicker({
                        dateFormat: "yy",
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
                }

                // Initialize datepicker for existing rows
                document.querySelectorAll('.training-year').forEach(input => {
                    initializeYearOnlyDatepicker(input);
                });

                // training section ended


                // Debug nationality dropdown logic
                console.log('Nationalities:', @json($nationalities));
                console.log('Selected Nationality:', @json($personalInfo->nationality ?? ''));

                // Debug hobby dropdown logic
                console.log('Hobbies:', @json($hobbies));
                console.log('Selected Hobby:', @json($personalInfo->hobby ?? ''));

                // Ensure nationality dropdown is populated
                const nationalitySelect = document.getElementById('nationality');

                nationalitySelect.innerHTML = '<option value="" disabled>Select your nationality</option>';
                @json($nationalities).forEach(nationality => {
                    const option = document.createElement('option');
                    option.value = nationality.id;
                    option.textContent = nationality.name;
                    if (nationality.id == @json($personalInfo->nationality ?? '')) {
                        option.selected = true;
                    }
                    nationalitySelect.appendChild(option);
                });

                // Log the innerHTML of the nationality dropdown after population
                console.log('Nationality Dropdown HTML:', nationalitySelect.innerHTML);

                // Populate hobby
                const hobbySelect = document.getElementById('hobby');
                hobbySelect.innerHTML = '<option value="" disabled>Select your hobby</option>';
                @json($hobbies).forEach(hobby => {
                    const option = document.createElement('option');
                    option.value = hobby.id;
                    option.textContent = hobby.name;
                    if (hobby.id == @json($personalInfo->hobby ?? '')) {
                        option.selected = true;
                    }
                    hobbySelect.appendChild(option);
                });

                // Populate NID/BID
                const nidRadio = document.getElementById('nidRadio');
                const bidRadio = document.getElementById('bidRadio');
                const nidInput = document.getElementById('nid-number');
                const bidInput = document.getElementById('bid-number');

                if (@json($personalInfo->identity_type) === 'nid') {
                    nidRadio.checked = true;
                    nidInput.value = @json($personalInfo->nid_number ?? '');
                    document.getElementById('nid-input-group').classList.remove('d-none');
                } else if (@json($personalInfo->identity_type) === 'bid') {
                    bidRadio.checked = true;
                    bidInput.value = @json($personalInfo->bid_number ?? '');
                    document.getElementById('bid-input-group').classList.remove('d-none');
                }

                // Initialize datepicker for existing and dynamically added passing year fields
                $(".passing-year, .training-year").datepicker({
                    dateFormat: "yy",
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

            // Experience date input event: hide error on change if fixed
            document.addEventListener('change', function (e) {
                if (e.target && (e.target.classList.contains('start-date') || e.target.classList.contains('end-date'))) {
                    validateExperienceDates();
                }
            });

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

            // Function to add new experience row
            function addExperienceRow() {
                const experienceTableBody = document.getElementById('experience-table-body');
                const newRow = `<tr>
                                                            <td><input type="text" class="form-control" placeholder="Enter Company Name"></td>
                                                            <td><input type="text" class="form-control" placeholder="Enter Designation"></td>
                                                            <td><input type="text" class="form-control" placeholder="Enter Location"></td>
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
                                                            <td><input type="number" class="form-control total-years" placeholder="Years" readonly></td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-danger remove-experience-row">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>`;
                experienceTableBody.insertAdjacentHTML('beforeend', newRow);

                // Initialize datepicker for the new row
                const lastRow = experienceTableBody.lastElementChild;
                const startDate = lastRow.querySelector('.start-date');
                const endDate = lastRow.querySelector('.end-date');

                $(startDate).datepicker({
                    dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "1950:2025",
                    maxDate: 0
                });

                $(endDate).datepicker({
                    dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "1950:2025",
                    maxDate: 0
                });

                // Set up the year calculation for this row
                setupDateListeners(lastRow);
            }            // Event listener for add experience row button
            document.querySelector('.add-experience-row').addEventListener('click', addExperienceRow);

            // Function to add new academic row
            function addAcademicRow() {
                const academicTableBody = document.getElementById('academic-rows');
                // Always add new rows with minus button at the bottom
                const newRow = `<tr>
                                                            <td><input type="text" class="form-control" placeholder="Enter Education Level"></td>
                                                            <td><input type="text" class="form-control" placeholder="Enter Department"></td>
                                                            <td><input type="text" class="form-control" placeholder="Enter Institute Name"></td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control passing-year" placeholder="Enter Passing Year" autocomplete="off">
                                                                    <span class="input-group-text psIcon" style="cursor: pointer;">
                                                                        <i class="bi bi-calendar"></i>
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td><input type="number" class="form-control" placeholder="Enter CGPA"></td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-danger remove-academic-row">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>`;
                academicTableBody.insertAdjacentHTML('beforeend', newRow);

                // Initialize datepicker for the new row
                const lastRow = academicTableBody.lastElementChild;
                const passingYear = lastRow.querySelector('.passing-year');

                $(passingYear).datepicker({
                    dateFormat: "yy",
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
            }

            // Event listener for add academic row button
            document.querySelector('.add-academic-row').addEventListener('click', addAcademicRow);

            // Event listener for remove buttons
            document.addEventListener('click', function (e) {
                if (e.target.closest('.remove-academic-row')) {
                    e.target.closest('tr').remove();
                }
            });


            /*
            // modal logic 

            */
        </script>
        <script src="/js/test-form.js"></script>
    </body>

    </html>
@endsection