<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftApiController extends Controller
{

    public function index()
    {
        $shift = Shift::all();
        // reponsenya dengan meta dan data
        return response()->json([
            'meta' => [
                'code' => 200,
                'message' => 'success',
                'total_data' => count($shift),
            ],
            'data' => $shift,
        ]);
    }
}
