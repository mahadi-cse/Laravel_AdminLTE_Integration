<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\PersonalInfo;
use App\Models\AcademicInfo;
use App\Models\ExperienceInfo;
use App\Models\TrainingInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'father-name' => ['required', 'string', 'max:255'],
            'mother-name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone-number' => ['required', 'string', 'max:20'],
            'profile-photo' => ['required', 'mimes:jpg,jpeg,png', 'max:2048'],
            'covid-certificate' => ['required', 'mimes:pdf', 'max:2048'],
            'identityType' => ['required', 'in:nid,bid'],
            'nid-number' => ['required_if:identityType,nid', 'nullable', 'digits_between:10,17'],
            'bid-number' => ['required_if:identityType,bid', 'nullable', 'digits_between:10,17'],
        ], [
            'name.required' => 'Name is required.',
            'father-name.required' => 'Father name is required.',
            'mother-name.required' => 'Mother name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'phone-number.required' => 'Phone number is required.',
            'phone-number.max' => 'Phone number must not exceed 20 characters.',
            'profile-photo.required' => 'Profile photo is required.',
            'profile-photo.mimes' => 'Profile photo must be a JPG or PNG image.',
            'profile-photo.max' => 'Profile photo must not exceed 2MB.',
            'covid-certificate.required' => 'Covid certificate is required.',
            'covid-certificate.mimes' => 'Covid certificate must be a PDF file.',
            'covid-certificate.max' => 'Covid certificate must not exceed 2MB.',
            'identityType.required' => 'Please select either NID or BID.',
            'identityType.in' => 'Invalid identity type selected.',
            'nid-number.required_if' => 'NID number is required when NID is selected.',
            'nid-number.digits_between' => 'NID number must be between 10 and 17 digits.',
            'bid-number.required_if' => 'BID number is required when BID is selected.',
            'bid-number.digits_between' => 'BID number must be between 10 and 17 digits.',
        ]);

        // Academic Info Validation
        $academic = json_decode($request->input('academic_info'), true);
        if (!is_array($academic) || count($academic) === 0) {
            return response()->json(['errors' => ['academic_info' => ['At least one academic record is required.']]], 422);
        }
        foreach ($academic as $i => $row) {
            $validator = \Validator::make($row, [
                'education_level' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'institute_name' => 'required|string|max:255',
                'passing_year' => 'required|digits:4',
                'cgpa' => 'required|numeric|max:5',
            ], [
                'education_level.required' => "Education Level is required (row ".($i+1).")",
                'department.required' => "Department is required (row ".($i+1).")",
                'institute_name.required' => "Institute Name is required (row ".($i+1).")",
                'passing_year.required' => "Passing Year is required (row ".($i+1).")",
                'passing_year.digits' => "Passing Year must be 4 digits (row ".($i+1).")",
                'cgpa.required' => "CGPA is required (row ".($i+1).")",
                'cgpa.numeric' => "CGPA must be a number (row ".($i+1).")",
                'cgpa.max' => "CGPA must be less than or equal to 5 (row ".($i+1).")",
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        }

        // Experience Info Validation
        $experience = json_decode($request->input('experience_info'), true);
        if (!is_array($experience) || count($experience) === 0) {
            return response()->json(['errors' => ['experience_info' => ['At least one experience record is required.']]], 422);
        }
        foreach ($experience as $i => $row) {
            $validator = \Validator::make($row, [
                'company_name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'company_name.required' => "Company Name is required (row ".($i+1).")",
                'designation.required' => "Designation is required (row ".($i+1).")",
                'location.required' => "Location is required (row ".($i+1).")",
                'start_date.required' => "Start Date is required (row ".($i+1).")",
                'start_date.date' => "Start Date must be a valid date (row ".($i+1).")",
                'end_date.required' => "End Date is required (row ".($i+1).")",
                'end_date.date' => "End Date must be a valid date (row ".($i+1).")",
                'end_date.after_or_equal' => "End Date must be after or equal to Start Date (row ".($i+1).")",
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        }

        // Training Info Validation
        $training = json_decode($request->input('training_info'), true);
        if (!is_array($training) || count($training) === 0) {
            return response()->json(['errors' => ['training_info' => ['At least one training record is required.']]], 422);
        }
        foreach ($training as $i => $row) {
            $validator = \Validator::make($row, [
                'training_title' => 'required|string|max:255',
                'institute_name' => 'required|string|max:255',
                'duration' => 'required|string|max:255',
                'training_year' => 'required|digits:4',
                'location' => 'required|string|max:255',
            ], [
                'training_title.required' => "Training Title is required (row ".($i+1).")",
                'institute_name.required' => "Institute Name is required (row ".($i+1).")",
                'duration.required' => "Duration is required (row ".($i+1).")",
                'training_year.required' => "Training Year is required (row ".($i+1).")",
                'training_year.digits' => "Training Year must be 4 digits (row ".($i+1).")",
                'location.required' => "Location is required (row ".($i+1).")",
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        }

        $user = Auth::user();
        $profilePhotoPath = null;
        $covidCertificatePath = null;
        if ($request->hasFile('profile-photo')) {
            $file = $request->file('profile-photo');
            $filename = Auth::user()->id . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            $profilePhotoPath = 'storage/uploads/' . $filename;
            Upload::create(['filename' => $filename, 'type' => 'profile']);
        }
        if ($request->hasFile('covid-certificate')) {
            $file = $request->file('covid-certificate');
            $filename = Auth::user()->id . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            $covidCertificatePath = 'storage/uploads/' . $filename;
            Upload::create(['filename' => $filename, 'type' => 'covid']);
        }
        $personal = PersonalInfo::create([
            'user_id' => $user ? $user->id : null,
            'name' => $request->input('name'),
            'father_name' => $request->input('father-name'),
            'mother_name' => $request->input('mother-name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone-number'),
            'present_address' => $request->input('present-address'),
            'permanent_address' => $request->input('permanent-address'),
            'nationality' => $request->input('nationality'),
            'hobby' => $request->input('hobby'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'identity_type' => $request->input('identityType'),
            'nid_number' => $request->input('nid-number'),
            'bid_number' => $request->input('bid-number'),
            'profile_photo_path' => $profilePhotoPath,
            'covid_certificate_path' => $covidCertificatePath,
            'description' => $request->input('description'),
        ]);

        // Store Academic Info
        foreach ($academic as $row) {
            AcademicInfo::create([
                'user_id' => $user ? $user->id : null,
                'ref_id' => $personal->id,
                'education_level' => $row['education_level'],
                'department' => $row['department'],
                'institute_name' => $row['institute_name'],
                'passing_year' => $row['passing_year'],
                'cgpa' => $row['cgpa'],
            ]);
        }
        // Store Experience Info
        foreach ($experience as $row) {
            ExperienceInfo::create([
                'user_id' => $user ? $user->id : null,
                'ref_id' => $personal->id,
                'company_name' => $row['company_name'],
                'designation' => $row['designation'],
                'location' => $row['location'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'total_years' => $row['total_years'] ?? null,
            ]);
        }
        // Store Training Info
        foreach ($training as $row) {
            TrainingInfo::create([
                'user_id' => $user ? $user->id : null,
                'ref_id' => $personal->id,
                'training_title' => $row['training_title'],
                'institute_name' => $row['institute_name'],
                'duration' => $row['duration'],
                'training_year' => $row['training_year'],
                'location' => $row['location'],
            ]);
        }

        return response()->json(['success' => 'Form and files uploaded successfully!']);
    }
}
