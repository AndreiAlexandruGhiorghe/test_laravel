<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized, must login'], 401);
        }
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'usernameField' => 'required',
            'passwordField' => 'required'
        ]);
        $admin = config('app.admin');
        if (
            $admin['username'] == $request->get('usernameField')
            && $admin['password'] == $request->get('passwordField')
        ) {
            $request->session()->put('idUser', $request->get('usernameField'));
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'successfully logged in'
                ]);
            }

            return redirect()->route('product.index');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'wrong username or password'
            ],401);
        }
        return redirect()->route('login.show');
    }

    public function destroy(Request $request)
    {
        $request->session()->remove('idUser');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Successfully loged out'
            ]);
        }

        return redirect()->route('product.index');
    }
}
