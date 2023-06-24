<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EkspresiController extends Controller
{
    public function index()
    {
        return view('landing-page.ekspresi-2023.ekspresi');
    }
}
