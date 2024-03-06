<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class ChartController extends Controller
{
    public function index(Request $request)
    {
            return view('report_table');
       
    }
}
