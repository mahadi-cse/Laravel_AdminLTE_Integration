<?php

namespace App\Http\Controllers;

use App\Models\AcademicInfo;
use Illuminate\Http\Request;
use App\Models\Form;
use Yajra\DataTables\DataTables;
use App\Models\Nationality;
use App\Models\Hobby;
use App\Models\PersonalInfo;
use App\Models\ExperienceInfo;
use App\Models\TrainingInfo;

class FormController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Form::select(['id', 'applicant_name', 'status', 'updated_at'])->get();

                return DataTables::of($data)
                    ->addIndexColumn()

                    // Format status column
                    ->editColumn('status', function ($row) {
                        if ($row->status == 0) {
                            return 'Submitted';
                        } elseif ($row->status == -1) {
                            return 'Draft';
                        }
                        return $row->status;
                    })

                    // Format updated_at with timezone
                    ->editColumn('updated_at', function ($row) {
                        return \Carbon\Carbon::parse($row->updated_at)
                            ->timezone('Asia/Dhaka')
                            ->format('d M, Y h:i A');  // Example: 24 May, 2025 04:05 AM
                    })

                    // Same width button for both Edit/Open
                    ->addColumn('action', function ($row) {
                        $widthStyle = 'style="width: 80px; text-align: center;"'; // Set fixed width
                        if ($row->status == -1) {
                            return '<a href="' . route('forms.edit', $row->id) . '" class="btn btn-warning btn-sm" ' . $widthStyle . '>Edit</a>';
                        } elseif ($row->status == 0) {
                            return '<a href="' . route('forms.show', $row->id) . '" class="btn btn-info btn-sm" ' . $widthStyle . '>Open</a>';
                        }
                        return '';
                    })


                    ->rawColumns(['action'])
                    ->make(true);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return view('application_list');
    }


  public function store(Request $request)
{
    $isDraft = $request->input('is_draft') == '-1';
    $user = auth()->user();
    $userId = $user ? $user->id : null;

    if ($user) {
        $applicantName = $request->input('name') ?: $request->input('applicant_name') ?: null;
        Form::updateOrCreate(
            ['user_id' => $user->id],
            [
                'applicant_name' => $applicantName,
                'status' => $isDraft ? '-1' : '0',
            ]
        );
    }

    if ($isDraft) {
        // Validation for draft (relaxed, but check file types/sizes and email format if present)
        $rules = [
            'email' => ['nullable', 'email'],
            'profile-photo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'covid-certificate' => ['nullable', 'file', 'mimes:pdf', 'max:2048'], // max 2MB
        ];
        $messages = [
            'email.email' => 'Please provide a valid email address.',
            'profile-photo.image' => 'Profile photo must be an image file.',
            'profile-photo.max' => 'Profile photo must be less than 2MB.',
            'covid-certificate.mimes' => 'COVID certificate must be a PDF file.',
            'covid-certificate.max' => 'COVID certificate must be less than 2MB.',
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Save or update personal info
        $personal = PersonalInfo::updateOrCreate(
            ['user_id' => $userId],
            [
                'name' => $request->input('name') ?: null,
                'father_name' => $request->input('father-name') ?: null,
                'mother_name' => $request->input('mother-name') ?: null,
                'email' => $request->input('email') ?: null,
                'phone_number' => $request->input('phone-number') ?: null,
                'present_address' => $request->input('present-address') ?: null,
                'permanent_address' => $request->input('permanent-address') ?: null,
                'nationality' => $request->input('nationality') ?: null,
                'hobby' => $request->input('hobby') ?: null,
                'dob' => $request->input('dob') ?: null,
                'gender' => $request->input('gender') ?: null,
                'identity_type' => $request->input('identityType') ?: null,
                'nid_number' => $request->input('nid-number') ?: null,
                'bid_number' => $request->input('bid-number') ?: null,
                'description' => $request->input('description') ?: null
            ]
        );

        // Academic Info
        $academic = json_decode($request->input('academic_info'), true);
        AcademicInfo::where('ref_id', $personal->id)->delete();
        if (is_array($academic)) {
            foreach ($academic as $row) {
                AcademicInfo::create([
                    'user_id' => $userId,
                    'ref_id' => $personal->id,
                    'education_level' => $row['education_level'] ?? null,
                    'department' => $row['department'] ?? null,
                    'institute_name' => $row['institute_name'] ?? null,
                    'passing_year' => $row['passing_year'] ?? null,
                    'cgpa' => $row['cgpa'] ?? null,
                ]);
            }
        }

        // Experience Info
        $experience = json_decode($request->input('experience_info'), true);
        ExperienceInfo::where('ref_id', $personal->id)->delete();
        if (is_array($experience)) {
            foreach ($experience as $row) {
                ExperienceInfo::create([
                    'user_id' => $userId,
                    'ref_id' => $personal->id,
                    'company_name' => $row['company_name'] ?? null,
                    'designation' => $row['designation'] ?? null,
                    'location' => $row['location'] ?? null,
                    'start_date' => $row['start_date'] ?? null,
                    'end_date' => $row['end_date'] ?? null,
                    'total_years' => $row['total_years'] ?? null,
                ]);
            }
        }

        // Training Info
        $training = json_decode($request->input('training_info'), true);
        TrainingInfo::where('ref_id', $personal->id)->delete();
        if (is_array($training)) {
            foreach ($training as $row) {
                TrainingInfo::create([
                    'user_id' => $userId,
                    'ref_id' => $personal->id,
                    'training_title' => $row['training_title'] ?? null,
                    'institute_name' => $row['institute_name'] ?? null,
                    'duration' => $row['duration'] ?? null,
                    'training_year' => $row['training_year'] ?? null,
                    'location' => $row['location'] ?? null,
                ]);
            }
        }

        // Handle file uploads
        if ($request->hasFile('profile-photo')) {
            $profilePhoto = $request->file('profile-photo');
            $profilePhotoName = 'profile_' . $userId . '_' . time() . '.' . $profilePhoto->getClientOriginalExtension();
            $profilePhotoPath = 'storage/profile_photos/' . $profilePhotoName;
            $profilePhoto->move(public_path('storage/profile_photos'), $profilePhotoName);
            $personal->update(['profile_photo_path' => $profilePhotoPath]);
        }

        if ($request->hasFile('covid-certificate')) {
            $covidCertificate = $request->file('covid-certificate');
            $covidCertificateName = 'covid_' . $userId . '_' . time() . '.' . $covidCertificate->getClientOriginalExtension();
            $covidCertificatePath = 'storage/covid_certificates/' . $covidCertificateName;
            $covidCertificate->move(public_path('storage/covid_certificates'), $covidCertificateName);
            $personal->update(['covid_certificate_path' => $covidCertificatePath]);
        }

        return response()->json(['success' => 'Draft saved successfully!', 'draft' => true, 'redirect' => route('forms.index')]);
    }

    // Handle full submission logic here...
}



    public function edit($id)
    {
        $form = Form::findOrFail($id);

        // Retrieve the latest personal info
        $personalInfo = PersonalInfo::where('user_id', $form->user_id)->latest()->first();

        // Retrieve the latest academic info filtered by ref_id
        $academicInfo = AcademicInfo::where('ref_id', $personalInfo->id)->latest()->get();

        // Retrieve the latest experience info filtered by ref_id
        $experienceInfo = ExperienceInfo::where('ref_id', $personalInfo->id)->latest()->get();

        // Retrieve the latest training info filtered by ref_id
        $trainingInfo = TrainingInfo::where('ref_id', $personalInfo->id)->latest()->get();

        // Retrieve all nationalities and hobbies
        $nationalities = Nationality::all();
        $hobbies = Hobby::all();

        $personalInfo->profile_photo_path = asset('/' . $personalInfo->profile_photo_path);
        $personalInfo->covid_certificate_path = asset('/' . $personalInfo->covid_certificate_path);

        // dd($personalInfo->profile_photo_path, $personalInfo->covid_certificate_path);

        return view('edit', compact('form', 'personalInfo', 'academicInfo', 'experienceInfo', 'trainingInfo', 'nationalities', 'hobbies'));
    }

    public function show($id)
    {
        $form = Form::findOrFail($id);
        $personalInfo = PersonalInfo::where('user_id', $form->user_id)->latest()->first();
        $academicInfo = AcademicInfo::where('ref_id', $personalInfo->id)->latest()->get();
        $experienceInfo = ExperienceInfo::where('ref_id', $personalInfo->id)->latest()->get();
        $trainingInfo = TrainingInfo::where('ref_id', $personalInfo->id)->latest()->get();
        $nationalities = Nationality::all();
        $hobbies = Hobby::all();
        $personalInfo->profile_photo_path = asset('/' . $personalInfo->profile_photo_path);
        $personalInfo->covid_certificate_path = asset('/' . $personalInfo->covid_certificate_path);
        return view('show', compact('form', 'personalInfo', 'academicInfo', 'experienceInfo', 'trainingInfo', 'nationalities', 'hobbies'));
    }
}
