<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard()
    {
        echo "Welcome to the Admin Dashboard!";
        exit();
        //return view('admin.dashboard');
    }

    public function login()
    {
        return view('pages.login');
    }

    public function loginPost(Request $request)
    {
        die('post data');
    }

}
