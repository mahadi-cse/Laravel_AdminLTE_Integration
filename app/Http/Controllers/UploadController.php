<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'profile-photo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'covid-certificate' => 'nullable|mimes:pdf|max:2048',
        ]);

        $result = [];
        if ($request->hasFile('profile-photo')) {
            $file = $request->file('profile-photo');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            Upload::create(['filename' => $filename, 'type' => 'profile']);
            $result['profile_photo_url'] = asset('storage/uploads/' . $filename);
        }
        if ($request->hasFile('covid-certificate')) {
            $file = $request->file('covid-certificate');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            Upload::create(['filename' => $filename, 'type' => 'covid']);
            $result['covid_certificate_url'] = asset('storage/uploads/' . $filename);
        }

        return response()->json(['success' => 'Form and files uploaded successfully!', 'data' => $result]);
    }
}
