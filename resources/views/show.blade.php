@extends('layouts.master')

@section('title', 'View Form')
@php($hideHeader = true)
@php($hideBreadcrumb = true)


@section('content')
    <div class="container">
        <div class="d-flex justify-content-start mb-2">
            <a href="{{ route('forms.downloadPdf', $form->id) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
        </div>
        <h2 class="mb-4">Application Details</h2>
        <div class="card mb-4">
            <div class="card-header"><b>Applicant Information</b></div>
            <div class="card-body p-0">
                <table class="table table-borderless mb-0" style="width:60%">
                    <tbody>
                        @if($personalInfo->profile_photo_path)
                            <tr>
                                <td class="label">Profile Photo</td>
                                <td> &nbsp;
                                    <img src="{{  $personalInfo->profile_photo_path }}"
                                        style="max-width:120px; max-height:120px; border:1px solid #ccc;" alt="Profile Photo">
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>Applicant's Name (English)</td>
                            <td>: {{ $personalInfo->name }}</td>
                        </tr>
                        <tr>
                            <td>Father's Name</td>
                            <td>: {{ $personalInfo->father_name }}</td>
                        </tr>
                        <tr>
                            <td>Mother's Name</td>
                            <td>: {{ $personalInfo->mother_name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: {{ $personalInfo->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td>: {{ $personalInfo->phone_number }}</td>
                        </tr>
                        <tr>
                            <td>Present Address</td>
                            <td>: {{ $personalInfo->present_address }}</td>
                        </tr>
                        <tr>
                            <td>Permanent Address</td>
                            <td>: {{ $personalInfo->permanent_address }}</td>
                        </tr>
                        <tr>
                            <td>Nationality</td>
                            <td>: {{ optional($nationalities->find($personalInfo->nationality))->name }}</td>
                        </tr>
                        <tr>
                            <td>Hobby</td>
                            <td>: {{ optional($hobbies->find($personalInfo->hobby))->name }}</td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>: {{ $personalInfo->dob }}</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>: {{ ucfirst($personalInfo->gender) }}</td>
                        </tr>
                        <tr>
                            <td>Identity Type</td>
                            <td>: {{ strtoupper($personalInfo->identity_type) }}</td>
                        </tr>
                        @if($personalInfo->identity_type === 'nid')
                            <tr>
                                <td>NID Number</td>
                                <td>: {{ $personalInfo->nid_number }}</td>
                            </tr>
                        @elseif($personalInfo->identity_type === 'bid')
                            <tr>
                                <td>BID Number</td>
                                <td>: {{ $personalInfo->bid_number }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td>Description</td>
                            <td>: {!! nl2br(e($personalInfo->description ?? "No Description ")) !!}</td>
                        </tr>
                        @if($personalInfo->covid_certificate_path)
                            <tr>
                                <td>Covid Certificate</td>
                                <td>: <a href="{{$personalInfo->covid_certificate_path}}" target="_blank">View Covid
                                        Certificate</a></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- <div class="row mb-4">
            <div class="col-md-6" style="width: 100%;">
                <div class="card h-100">
                    <div class="card-header"> <b> Profile Photo </b></div>
                    <div class="card-body text-center">
                        @if($personalInfo->profile_photo_path)
                            <img src="{{$personalInfo->profile_photo_path}}" class="img-thumbnail mb-2"
                                style="max-width:180px;">
                        @else
                            <span class="text-muted">No photo uploaded</span>
                        @endif
                    </div>
                </div>
            </div>
        </div> -->
        <div class="card mb-4">
            <div class="card-header"> <b>Academic Information </b></div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Education Level</th>
                            <th>Department</th>
                            <th>Institute Name</th>
                            <th>Passing Year</th>
                            <th>CGPA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($academicInfo as $row)
                            <tr>
                                <td>{{ $row->education_level }}</td>
                                <td>{{ $row->department }}</td>
                                <td>{{ $row->institute_name }}</td>
                                <td>{{ $row->passing_year }}</td>
                                <td>{{ $row->cgpa }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header"> <b> Experience </b> </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Designation</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Years</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($experienceInfo as $row)
                            <tr>
                                <td>{{ $row->company_name }}</td>
                                <td>{{ $row->designation }}</td>
                                <td>{{ $row->location }}</td>
                                <td>{{ $row->start_date }}</td>
                                <td>{{ $row->end_date }}</td>
                                <td>{{ $row->total_years }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header"> <b> Training & Certification </b></div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Training Title</th>
                            <th>Institute Name</th>
                            <th>Duration</th>
                            <th>Training Year</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trainingInfo as $row)
                            <tr>
                                <td>{{ $row->training_title }}</td>
                                <td>{{ $row->institute_name }}</td>
                                <td>{{ $row->duration }}</td>
                                <td>{{ $row->training_year }}</td>
                                <td>{{ $row->location }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{ route('forms.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection