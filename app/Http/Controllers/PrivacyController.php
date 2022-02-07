<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    /**
     * プライバシーポリシー画面
     *
     * @return void
     */
    public function index()
    {
        return view('privacy');
    }
}
