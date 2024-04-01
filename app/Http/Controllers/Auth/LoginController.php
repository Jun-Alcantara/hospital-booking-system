<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class LoginController extends Controller
{
    public function show()
    {
        return inertia('Auth/Login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            if ($user->status == 0) {
                return redirect('/forbidden');
            }

            return redirect()->route('console.dashboard');
        }

        return back()->withErrors([
            'email' => 'This credentials does not matched any of our records'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function manualLogout(Request $request)
    {
        $this->logout($request);
        return redirect('/console/login');
    }
}
