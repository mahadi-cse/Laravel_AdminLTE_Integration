<?php

namespace App\Http\Controllers;

use App\Models\Nationality;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $query = Nationality::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        $nationalities = $query->orderBy('name')->limit(20)->get(['id', 'name']);
        return response()->json([
            'results' => $nationalities->map(function ($nationality) {
                return [
                    'id' => $nationality->id,
                    'text' => $nationality->name,
                ];
            }),
        ]);
    }
}
