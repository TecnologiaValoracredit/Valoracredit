<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreApplicationController extends Controller
{
    public function index()
    {
        
        // $allowAdd = auth()->user()->hasPermissions("requisitions.create");
        return view('pre_applications.index');
    }
}
