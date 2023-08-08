<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function Showlogin()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $validator  = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'الرجاء ادخال  الاميل'
        ]);


        if ($validator) {
            $credentials = [
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ];

            if (Auth::guard("user")->attempt($credentials)) {
                session()->flash('message', 'Logged in successfully');
                return redirect()->route('home');
            } else {
                session()->flash('message', 'فشل تسجيل الدخول، أوراق اعتماد خاطئة');
                return redirect()->back();
            }
        } else {
            session()->flash('message', 'هناك أخطاء في البيانات المدخلة');
            return redirect()->back();
        }
    }
}
