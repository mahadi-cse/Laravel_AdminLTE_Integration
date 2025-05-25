<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use Yajra\DataTables\DataTables;


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
        return '<a href="' . route('forms.edit', $row->id) . '" class="btn btn-info btn-sm" ' . $widthStyle . '>Open</a>';
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
            // Ensure the applicant_name is set (use name field as fallback)
            $applicantName = $request->input('name') ?: $request->input('applicant_name') ?: null;
            \App\Models\Form::updateOrCreate(
                attributes: ['user_id' => $user->id],
                values: [
                    'applicant_name' => $applicantName,
                    'status' => $isDraft ? '-1' : '0',
                ]
            );
        }

        if ($isDraft) {
            $fields = [
                'user_id' => $userId,
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
                'profile_photo_path' => null,
                'covid_certificate_path' => null,
                'description' => $request->input('description') ?: null,
                'status' => 'draft',
            ];
            $personal = \App\Models\PersonalInfo::create($fields);

            // Academic Info (optional for draft)
            $academic = json_decode($request->input('academic_info'), true);
            if (is_array($academic)) {
                foreach ($academic as $row) {
                    \App\Models\AcademicInfo::create([
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
            // Experience Info (optional for draft)
            $experience = json_decode($request->input('experience_info'), true);
            if (is_array($experience)) {
                foreach ($experience as $row) {
                    \App\Models\ExperienceInfo::create([
                        'user_id' => $userId,
                        'ref_id' => $personal->id,
                        'company_name' => $row['company_name'] ?: null,
                        'designation' => $row['designation'] ?: null,
                        'location' => $row['location'] ?: null,
                        'start_date' => $row['start_date'] ?: null,
                        'end_date' => $row['end_date'] ?: null,
                        'total_years' => $row['total_years'] ?: null,
                    ]);
                }
            }
            // Training Info (optional for draft)
            $training = json_decode($request->input('training_info'), true);
            if (is_array($training)) {
                foreach ($training as $row) {
                    \App\Models\TrainingInfo::create([
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
            return response()->json(['success' => 'Draft saved successfully!', 'draft' => true]);
        }

        // ...existing code for full validation and submission (similar to UploadController)...
    }
}
