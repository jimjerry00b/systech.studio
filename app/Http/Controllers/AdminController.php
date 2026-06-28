<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\LoginService;
use Exception;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    protected LoginService $service;

    function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    public function dashboard()
    {
        return view('dashboard.home');
    }

    public function login()
    {
        return view('pages.login');
    }

    public function loginPost(LoginRequest $request)
    {
        try{
            $this->service->login($request);
            return redirect()->route('dashboard')->with('message', 'Login Sucessful');
        }catch(Exception $e){
            return redirect()->back()->with('error', 'Credential not matched');
        }
    }

    
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('message', 'Login out successful');
    }

}
