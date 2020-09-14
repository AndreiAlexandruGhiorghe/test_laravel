<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show(Request $request)
    {
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
                return json_encode([
                    'message' => 'successfully logged in',
                    'redirect' => '#product'
                ]);
            }
            return redirect()->route('product.index');
        }

        if ($request->expectsJson()) {
            return json_encode([
                'message' => 'wrong username or password',
                'redirect' => '#login'
            ]);
        }
        return redirect()->route('login.show');
    }

    public function destroy(Request $request)
    {
        $request->session()->remove('idUser');
        return redirect()->route('product.index');
    }
}
