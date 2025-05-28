@extends('layouts.master')

@section('title', 'View Form')
@php($hideHeader = false)
@php($hideBreadcrumb = true)

@section('content')
    <div class="container-fluid px-2 px-md-4">
        <div class="d-flex justify-content-start mb-2">
            <a href="{{ route('forms.downloadPdf', $form->id) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>
        </div>
        <h2 class="mb-4">Application Details</h2>
        <div class="card mb-4">
            <div class="card-header"><b>Applicant Information</b></div>
            <div class="card-body">
                <div class="row g-3">
                    @if($personalInfo->profile_photo_path)
                        <div class="col-12 text-center mb-3">
                            <img src="{{  $personalInfo->profile_photo_path }}" style="max-width:120px; max-height:120px; border:1px solid #ccc;" alt="Profile Photo">
                        </div>
                    @endif
                    <div class="col-12 col-md-6">
                        <strong>Applicant's Name :</strong> {{ $personalInfo->name }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Father's Name:</strong> {{ $personalInfo->father_name }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Mother's Name:</strong> {{ $personalInfo->mother_name }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Email:</strong> {{ $personalInfo->email }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Phone Number:</strong> {{ $personalInfo->phone_number }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Present Address:</strong> {{ $personalInfo->present_address }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Permanent Address:</strong> {{ $personalInfo->permanent_address }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Nationality:</strong> {{ optional($nationalities->find($personalInfo->nationality))->name }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Hobby:</strong> {{ optional($hobbies->find($personalInfo->hobby))->name }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Date of Birth:</strong> {{ $personalInfo->dob }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Gender:</strong> {{ ucfirst($personalInfo->gender) }}
                    </div>
                    <div class="col-12 col-md-6">
                        <strong>Identity Type:</strong> {{ strtoupper($personalInfo->identity_type) }}
                    </div>
                    @if($personalInfo->identity_type === 'nid')
                        <div class="col-12 col-md-6">
                            <strong>NID Number:</strong> {{ $personalInfo->nid_number }}
                        </div>
                    @elseif($personalInfo->identity_type === 'bid')
                        <div class="col-12 col-md-6">
                            <strong>BID Number:</strong> {{ $personalInfo->bid_number }}
                        </div>
                    @endif
                    <div class="col-12">
                        <strong>Description:</strong> {!! nl2br(e($personalInfo->description ?? "No Description ")) !!}
                    </div>
                    @if($personalInfo->covid_certificate_path)
                        <div class="col-12">
                            <strong>Covid Certificate:</strong> <a href="{{$personalInfo->covid_certificate_path}}" target="_blank">View Covid Certificate</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header"> <b>Academic Information </b></div>
            <div class="card-body p-0">
                <div class="table-responsive">
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
        </div>
        <div class="card mb-4">
            <div class="card-header"> <b> Experience </b> </div>
            <div class="card-body p-0">
                <div class="table-responsive">
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
        </div>
        <div class="card mb-4">
            <div class="card-header"> <b> Training & Certification </b></div>
            <div class="card-body p-0">
                <div class="table-responsive">
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
        </div>
        <a href="{{ route('forms.index') }}" class="btn btn-secondary mb-4">Back to List</a>
    </div>
    <style>
        @media (max-width: 767.98px) {
            .card-body .row.g-3 > div[class^='col-'] {
                flex: 0 0 100%;
                max-width: 100%;
            }
            .card-body img {
                max-width: 80vw;
                height: auto;
            }
        }
    </style>
@endsection