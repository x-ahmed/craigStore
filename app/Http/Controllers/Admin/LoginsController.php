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
        return view('admin.auth.login');
    }

    // LOG THE USER IN DASHBOARD
    public function login(LoginRequest $request)
    {   
        // REMEMBER ME CHECK
        $rememberMe = $request->has('remember-me')? true: false;

        if (
            auth()->guard('admin')->attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ])
        ) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->with([
            'error' => 'No such admin'
        ]);
    }
}
