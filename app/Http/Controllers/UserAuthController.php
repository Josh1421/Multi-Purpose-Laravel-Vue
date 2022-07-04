<?php

namespace App\Http\Controllers;

use App\Models\UserAuth;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function register()
    {
        return view('UserAuth.register');
    }

    public function register_validate(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|unique:user_auths',
            'username' => 'required|unique:user_auths',
            'password' => 'required',
        ]);
        $result = UserAuth::create($data);
        if($result)
        {
            $request->session()->flash('success', 'Account sucessfully created');
            return redirect("/register");
        }
    }
    
    public function login()
    {
        return view("UserAuth.login");
    }

    public function login_validate(Request $request)
    {
        $data = UserAuth::where('email', $request->email)->where('password', $request->password)->get();
        if($data->count() > 0)
        {
            $request->session()->put('user', $data[0]);
            return redirect("/home");
        }
        else{
            $request->session()->flash('failed', 'Wrong email or password');
            return redirect("/login");
        }
    }

    public function home(Request $request)
    {
        if($request->session()->has('user'))
        {
            return view("UserAuth.home");
        }
        else{
            return redirect("/login");
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect("/login");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAuth  $userAuth
     * @return \Illuminate\Http\Response
     */
    public function show(UserAuth $userAuth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAuth  $userAuth
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAuth $userAuth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAuth  $userAuth
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAuth $userAuth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAuth  $userAuth
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAuth $userAuth)
    {
        //
    }
}
