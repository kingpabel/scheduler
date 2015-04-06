<?php namespace App\Http\Controllers;
use App\Company;
use App\Schedule;
use App\User;
use Auth;
use Request;
use Session;
use Redirect;
use Mail;
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

    public function anyCreate(){
        if(Input::all()){
            $rules = array(
                'first_name' => 'required|alpha_num_spaces',
                'last_name' => 'required|alpha_num_spaces',
                'email' => "required|email|unique:users,email",
                'phone' => 'required|phone_number',
                'password'  => 'required|same:confirm_password|min:6',
            );
            $messages = array(
                'password.same' => 'Password and Confirm password are not Matched',
            );
            /* Laravel Validator Rules Apply */
            $validator = Validator::make(Input::all(), $rules, $messages);
            if ($validator->fails()):
                $validationError =  $validator->messages()->first();

            Session::flash('error', $validationError);

            return Redirect::back()->with('input', Input::all());
            else:
                $user = new User();
                $user->first_name = Input::get('first_name');
                $user->last_name = Input::get('last_name');
                $user->email = Input::get('email');
                $user->phone = Input::get('phone');
                $user->password = Hash::make(Input::get('password'));
                $user->save();
                $credentials = array(
                    'email' => Request::input('email'),
                    'password' => Request::input('password'),
                    'status' => 1
                );
                if(Auth::attempt( $credentials ))
                {
                    Session::flash('success', 'Thanks For Create Account');
                    return redirect()->intended('user');
                }
            endif;
        }else {
            return view('create');
        }
    }

    public function getMailMe(){
        $data['mailProfile'] = User::where('email_status','on')
            ->get();
        foreach($data['mailProfile'] as $mailProfile){
            $eventInfo = Schedule::where('user_id', $mailProfile->id)
                ->where('start_time', '>=', date('Y-m-d 00:00:00'))
                ->where('start_time', '<=', date('Y-m-d 23:59:59'))
                ->get();

            Mail::send('eventMail', array('mailProfile'=> $eventInfo), function($message) use($mailProfile) {
            $message
                ->from('kingpabel@kingpabel.com', 'Kingpabel Scheduler')
                ->to('ippabel@gmail.com', 'username')
                ->subject('Kingpabel Scheduler Event'. date('Y-m-d'));
             });
        }

    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

}