<?php namespace App\Http\Controllers;
use App\Company;
use App\User;
use Auth;
use Request;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AccountController extends Controller {

    public function postLogin()
    {
        $credentials = array(
            'email' => Request::input('email'),
            'password' => Request::input('password'),
            'status' => 1
        );
        if(Auth::attempt( $credentials ))
        {
            return redirect()->intended('user');
        }
        else
        {
            Session::flash('error', 'Your ID or Password Invalid');
            return redirect('/');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

}