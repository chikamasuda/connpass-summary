<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsvDownloadController extends Controller
{
    public function index()
    {
        return view('csv_download');
    }
}
