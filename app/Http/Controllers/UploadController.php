<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\PersonalInfo;
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

        $user = Auth::user();
        $profilePhotoPath = null;
        $covidCertificatePath = null;
        if ($request->hasFile('profile-photo')) {
            $file = $request->file('profile-photo');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            $profilePhotoPath = 'storage/uploads/' . $filename;
            Upload::create(['filename' => $filename, 'type' => 'profile']);
        }
        if ($request->hasFile('covid-certificate')) {
            $file = $request->file('covid-certificate');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            $covidCertificatePath = 'storage/uploads/' . $filename;
            Upload::create(['filename' => $filename, 'type' => 'covid']);
        }
        PersonalInfo::create([
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
        return response()->json(['success' => 'Form and files uploaded successfully!']);
    }
}
