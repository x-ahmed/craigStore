<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginsController extends Controller
{
    // SHOW LOGIN VIEW.
    public function showLogin()
    {
        // LOGIN FORM VIEW
        return view('admin.auth.login');
    }

    // LOG THE ADMIN & REDIRECT TO  DASHBOARD
    public function login(LoginRequest $request)
    {
        try {
            
            // REMEMBER ME CHECKBOX
            $rememberMe = $request->has('remember-me')? true: false;

            // EMAIL & PASSWORD DB EXISTANCE CHECK
            if (
                // AUTHORIZED ADMIN GUARDED CHECK
                // auth()->guard('admin')->attempt([
                Auth::guard('admin')->attempt([
                    'email'     => $request->input('email'),        // ADMIN EMAIL
                    'password'  => $request->input('password')      // ADMIN PASSWORD
                ])
            ) {
                // REDIRECT TO ADMIN DASHBOARD VIEW
                return redirect()->route('admin.dashboard');
            }

            // REDIRECT BACK TO LOGIN PAGE WITH ERROR MESSAGE
            return redirect()->back()->with([
                'error' => 'No such admin'
            ]);
            
        } catch (\Throwable $th) {
            
            // REDIRECT TO ADMIN BACK WITH ERROR MESSAGE
            return redirect()->route('admin.dashboard')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }
        
    }
}
