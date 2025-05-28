<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .section-title { font-weight: bold; font-size: 16px; margin-top: 20px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; }
        .noborder td { border: none; }
        .label { width: 220px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="section-title">Applicant Information</div>
    <table class="noborder">
        <tbody>
        @if($personalInfo->profile_photo_path)
            <tr>
                <td class="label">Profile Photo</td>
                <td colspan="3">:
                    <img src="{{ public_path(str_replace(asset('/'), '', $personalInfo->profile_photo_path)) }}" style="max-width:120px; max-height:120px; border:1px solid #ccc;" alt="Profile Photo">
                </td>
            </tr>
        @endif
        <tr>
            <td class="label">Applicant's Name (English)</td><td>: {{ $personalInfo->name }}</td>
            <td class="label">Father's Name</td><td>: {{ $personalInfo->father_name }}</td>
        </tr>
        <tr>
            <td class="label">Mother's Name</td><td>: {{ $personalInfo->mother_name }}</td>
            <td class="label">Email</td><td>: {{ $personalInfo->email }}</td>
        </tr>
        <tr>
            <td class="label">Phone Number</td><td>: {{ $personalInfo->phone_number }}</td>
            <td class="label">Present Address</td><td>: {{ $personalInfo->present_address }}</td>
        </tr>
        <tr>
            <td class="label">Permanent Address</td><td>: {{ $personalInfo->permanent_address }}</td>
            <td class="label">Nationality</td><td>: {{ optional($nationalities->find($personalInfo->nationality))->name }}</td>
        </tr>
        <tr>
            <td class="label">Hobby</td><td>: {{ optional($hobbies->find($personalInfo->hobby))->name }}</td>
            <td class="label">Date of Birth</td><td>: {{ $personalInfo->dob }}</td>
        </tr>
        <tr>
            <td class="label">Gender</td><td>: {{ ucfirst($personalInfo->gender) }}</td>
            <td class="label">Identity Type</td><td>: {{ strtoupper($personalInfo->identity_type) }}</td>
        </tr>
        @if($personalInfo->identity_type === 'nid')
        <tr>
            <td class="label">NID Number</td><td>: {{ $personalInfo->nid_number }}</td>
            <td></td><td></td>
        </tr>
        @elseif($personalInfo->identity_type === 'bid')
        <tr>
            <td class="label">BID Number</td><td>: {{ $personalInfo->bid_number }}</td>
            <td></td><td></td>
        </tr>
        @endif
        <tr>
            <td class="label">Description</td><td colspan="3">: {!! nl2br(e($personalInfo->description  ?? "No Description ")) !!}</td>
        </tr>
        @if($personalInfo->covid_certificate_path)
        <tr>
            <td class="label">Covid Certificate</td><td colspan="3">: <a href="{{$personalInfo->covid_certificate_path}}">View Covid Certificate</a></td>
        </tr>
        @endif
        </tbody>
    </table>
    <div class="section-title">Academic Information</div>
    <table>
        <thead><tr><th>Education Level</th><th>Department</th><th>Institute Name</th><th>Passing Year</th><th>CGPA</th></tr></thead>
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
    <div class="section-title">Experience</div>
    <table>
        <thead><tr><th>Company Name</th><th>Designation</th><th>Location</th><th>Start Date</th><th>End Date</th><th>Total Years</th></tr></thead>
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
    <div class="section-title">Training & Certification</div>
    <table>
        <thead><tr><th>Training Title</th><th>Institute Name</th><th>Duration</th><th>Training Year</th><th>Location</th></tr></thead>
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
</body>
</html>
