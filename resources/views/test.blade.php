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
                        <div id="identity-error" class="text-danger mt-2" style="display:none; font-size:0.95em;"></div>
                        <!-- Input field section -->
                        <div class="mt-4">
                            <!-- NID -->
                            <div id="nid-input-group" class="align-items-center mb-2 d-none">
                                <label for="nid-number" class="form-label me-2 mb-0" style="white-space: nowrap;">NID
                                    Number</label>
                                <input type="number" class="form-control" id="nid-number" name="nid-number"
                                    placeholder="Enter NID">
                                <div id="nid-number-error" class="text-danger mt-1" style="display:none; font-size:0.95em;"></div>
                            </div>
                            <!-- BID -->
                            <div id="bid-input-group" class="align-items-center d-none">
                                <label for="bid-number" class="form-label me-2 mb-0" style="white-space: nowrap;">BID
                                    Number</label>
                                <input type="number" class="form-control" id="bid-number" name="bid-number"
                                    placeholder="Enter BID">
                                <div id="bid-number-error" class="text-danger mt-1" style="display:none; font-size:0.95em;"></div>
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
                                            <i class="bi bi-calendar"></i> <!-- Bootstrap Icons -->
                                        </span>
                                    </div>
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
                    <div id="cgpa-error" class="text-danger mt-1" style="display:none; font-size:0.95em;"></div>
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
                    <div id="experience-date-error" class="text-danger mt-1" style="display:none; font-size:0.95em;"></div>
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
                                    <div class="input-group">
                                        <input type="text" class="form-control training-year" placeholder="Enter Training Year" autocomplete="off">
                                        <span class="input-group-text tyIcon" style="cursor: pointer;">
                                            <i class="bi bi-calendar"></i> <!-- Bootstrap Icons -->
                                        </span>
                                    </div>
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
    <script src="/js/test-form.js"></script>

</body>

</html>
@endsection