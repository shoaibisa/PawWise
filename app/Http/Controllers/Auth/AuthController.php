<?php

namespace App\Http\Controllers\Auth;

use App\Models\Address;
use App\Models\country;



use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    //

    public function getUserReg()
    {
        
        $countries = country::all();
        return view('auth.register', ['countries' => $countries]);
    }
    public function postRegister(Request $req)
    {
        $user = User::where('email', $req->email)->first();
        if ($user) {
            return redirect('/register')->with(['msg' => "User With this email already exist", 'isError' => true]);
        }
        if (strlen($req->password) < 5) {
            return redirect('/register')->with(['msg' => "Password length min 5 required!", 'isError' => true]);
        }
        // return Hash::make($req->password);
        // return $req->file('image');
      $path =   Storage::disk('public')->put('profile',$req->file('image'));
       
        $user = User::create([
            "name" => $req->name,
            "email" => $req->email,
            "profile_img"=>$path,
            "password" =>  Hash::make($req->password),
        ]);
        $address = new Address;
        $address->city_id = $req->city;
        $address->state_id = $req->state;
        $address->country_id = $req->country;
        $address->user_id = $user->id;
        $address->save();

        if ($user) {
            $isError = false;
            $msg = "User Inserted!";

            if($req->rtype=="bank"){
                $user->assignRole('bank');
            } 
                $user->assignRole('user');
            
        } else {
            $isError = true;
            $msg = "User Insertion failed!";
        }

        return redirect('/register')->with(['msg' => $msg, 'isError' => $isError]);
    }
    public function getLogin()
    {
        return view('auth.login');
    }
    public function postLogin(Request $req)
    {
        $credentials = $req->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]
        );

        $user = User::where('email', $credentials['email'])->first();
        // return $user;
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            // return back()->withErrors([
            //     'msg' => 'Something wrong in email or password!',
            //     'isError' => true
            // ])->onlyInput('email');
            return redirect('/login')->with([
                'msg' => 'Something wrong in email or password!',
                'isError' => true
            ]);
        }
        if($user->verified==0){
            return redirect('/login')->with([
                'msg' => 'Kindly wait for your account verification!',
                'isError' => true
            ]);
        }

        Auth::login($user);
        $user = Auth::user();
        $req->session()->regenerate();

        if(!$user->hasAnyRole(['admin','bank','user'])){
          
            $user->assignRole('user');
        }
        if($user->hasRole('bank')){
            $user->assignRole('user');
        }
        return redirect()->intended('dashboard');
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/login');
    }
}
