<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;


class AdminController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function login()
    {

            return view('auth.login-admin');

    }

    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|max:255',
            'password' => 'required|min:5',
        ]);

        if( $validator->fails() ){
            return redirect('/admin/login')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials =['email'=>$request->get('email'), 'password'=>$request->get('password')];

        if( Auth::guard('admin')->attempt($credentials) ){
            return redirect('/admin');
        }else{
            return redirect('/admin/login')
                ->withErrors(['errors'=>'Invalid Details'])
                ->withInput();
        }

    }

    public function logout(){

        Auth::guard('admin')->logout();

        return redirect('/admin/login');
    }

}

