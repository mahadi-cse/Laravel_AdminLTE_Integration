@extends('layouts.master')

@section('title', 'View Form')
@php($hideHeader = false)
@php($hideBreadcrumb = true)



@section('content')
    <div class="container-fluid px-2 px-md-4">
        <div class="d-flex justify-content-start mb-2">
            <a href="{{ route('forms.downloadPdf', $form->id) }}" class="btn btn-danger">
                <i class="fa fa-file-pdf"></i> Download PDF
            </a>
        </div>
        <h2 class="mb-4">Application Details</h2>
        <div class="card mb-4">
            <div class="card-header"><b>Applicant Information</b></div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="width:100%;">
                    <tbody>
                    @if($personalInfo->profile_photo_path)
                        <tr>
                            <td class="fw-bold" style="width:220px;">Profile Photo</td>
                            <td style="width:10px;">:</td>
                            <td colspan="2">
                                <img src="{{ $personalInfo->profile_photo_path }}" style="max-width:120px; max-height:120px; border:1px solid #ccc;" alt="Profile Photo">
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td class="fw-bold">Applicant's Name</td><td>:</td><td>{{ $personalInfo->name }}</td>
                        <td class="fw-bold">Father's Name</td><td>:</td><td>{{ $personalInfo->father_name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Mother's Name</td><td>:</td><td>{{ $personalInfo->mother_name }}</td>
                        <td class="fw-bold">Email</td><td>:</td><td>{{ $personalInfo->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Phone Number</td><td>:</td><td>{{ $personalInfo->phone_number }}</td>
                        <td class="fw-bold">Present Address</td><td>:</td><td>{{ $personalInfo->present_address }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Permanent Address</td><td>:</td><td>{{ $personalInfo->permanent_address }}</td>
                        <td class="fw-bold">Nationality</td><td>:</td><td>{{ optional($nationalities->find($personalInfo->nationality))->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Hobby</td><td>:</td><td>{{ optional($hobbies->find($personalInfo->hobby))->name }}</td>
                        <td class="fw-bold">Date of Birth</td><td>:</td><td>{{ $personalInfo->dob }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Gender</td><td>:</td><td>{{ ucfirst($personalInfo->gender) }}</td>
                        <td class="fw-bold">Identity Type</td><td>:</td><td>{{ strtoupper($personalInfo->identity_type) }}</td>
                    </tr>
                    @if($personalInfo->identity_type === 'nid')
                    <tr>
                        <td class="fw-bold">NID Number</td><td>:</td><td>{{ $personalInfo->nid_number }}</td>
                        <td></td><td></td><td></td>
                    </tr>
                    @elseif($personalInfo->identity_type === 'bid')
                    <tr>
                        <td class="fw-bold">BID Number</td><td>:</td><td>{{ $personalInfo->bid_number }}</td>
                        <td></td><td></td><td></td>
                    </tr>
                    @endif
                    <tr>
                        <td class="fw-bold">Description</td><td>:</td><td colspan="4">{!! nl2br(e($personalInfo->description ?? "No Description ")) !!}</td>
                    </tr>
                    @if($personalInfo->covid_certificate_path)
                    <tr>
                        <td class="fw-bold">Covid Certificate</td><td>:</td><td colspan="4"><a href="{{$personalInfo->covid_certificate_path}}" target="_blank">View Covid Certificate</a></td>
                    </tr>
                    @endif
                    </tbody>
                </table>
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