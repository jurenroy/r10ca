<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthManager extends Controller
{
    // Login
    public function login() {
        return view('login');
    }

    // Authenticate Login
    public function loginProcess(Request $request) {
        // Received and validate the credentials
        $request->validate([
            'username'  =>  'required',
            'password'  =>  'required'
        ]);

        // Process the validated credentials
        $credentials = $request->only('username', 'password');
        if(Auth::attempt($credentials)) {
            return response()->json(['redirect' => 'admin']);
        }

        return response()->json(['message' => 'Something went wrong']);
    }

    // Registration
    public function registration() {
        return view('registration');
    }

    // Process new registration
    public function registrationProcess(Request $request) {
        // Recieve and validate the data inputs
        $validatedData = $request->validate([
            'firstname'     =>  'required',
            'middlename'    =>  'required',
            'lastname'      =>  'required',
            'suffix'        =>  '',
            'division'      =>  'required'
        ]);

        // Process the login sequence
        $userData = new User();
        $userData->firstname    = $validatedData['firstname'];
        $userData->middlename   = $validatedData['middlename'];
        $userData->lastname     = $validatedData['lastname'];
        $userData->suffix       = $validatedData['suffix'];
        $userData->division     = $validatedData['division'];
        $userData->password     = 'RANo7942';
        $userData->username     = strtolower(str_replace(' ', '', $validatedData['firstname'] . '.' . $validatedData['lastname']));

        $user = $userData->save();

        return response()->json($user);
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->intended(route('login'));
    }
}
