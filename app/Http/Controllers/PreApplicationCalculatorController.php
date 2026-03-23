<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreApplicationCalculatorController extends Controller
{
    public function index()
    {
        
        // $allowAdd = auth()->user()->hasPermissions("requisitions.create");
        return view('pre_applications_calculator.index');
    }
}
