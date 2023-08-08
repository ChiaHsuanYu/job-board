<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * 顯示登入頁面
     */
    public function create()
    {
        Auth::check();
        if (Auth::viaRemember()) {
            return redirect()->intended('/');
        }
        return view('auth.create');
    }

    /**
     * 登入
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');
        
        if(Auth::attempt($credentials, $remember)){
            return redirect()->intended('/');
        }else{
            return redirect()->back()
                ->with('error', __('Invalid credentials') );
        }
    }

    /**
     * 登出
     */
    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }

    // 修改網站語言
    public function setlang(Request $request, $lang){
        switch($lang){
            case 'en':
            case 'zh_TW':
                App::setLocale($lang);
                session(['locale'=> App::getLocale()]);
                break;
            default:
                App::setLocale(config('app.fallback_locale'));
                session(['locale'=> App::getLocale()]);
                break;
        }
        return redirect()->back();
    }
}
