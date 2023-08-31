<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthManager extends Controller
{
    // Login
    public function login() {
        return view('login');
    }

    // Authenticate Login
    public function loginProcess() {

    }

    // Registration
    public function registration() {
        return view('registration');
    }

    // Process new registration
    public function registrationProcess() {

    }
}
