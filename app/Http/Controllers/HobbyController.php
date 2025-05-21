<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;

class HobbyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $query = Hobby::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        $hobbies = $query->orderBy('name')->limit(20)->get(['id', 'name']);
        return response()->json([
            'results' => $hobbies->map(function ($hobby) {
                return [
                    'id' => $hobby->id,
                    'text' => $hobby->name,
                ];
            }),
        ]);
    }
}
