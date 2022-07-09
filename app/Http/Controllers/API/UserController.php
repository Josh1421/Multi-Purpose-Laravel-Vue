<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File; 

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'bio' => $request['bio'],
            'type' => $request['type'],
            'photo' => "profile.png",
            'password' => Hash::make($request['password']),
        ]);
    }

    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user =  auth('api')->user();
        $currentPhoto = $user->photo;
        if(!empty($request->password)){
            $passwordValidation = 'sometimes|required|min:6';
        }else{
            $passwordValidation = '';
        }
        
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'username' => 'required|unique:users,username,'.$user->id,
            'password' => $passwordValidation,
        ]);
        
        if($request->photo != $currentPhoto)
        {
            //change new photo
            $name = time() . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            Image::make($request->photo)->save(public_path('img/profile/').$name);
            //store the new photo name in request then update it
            $request->merge(['photo' => $name]);

            //deleting old photo if change new photo
            $userPhoto = public_path('img/profile/').$currentPhoto;
            if('img/profile/'.$currentPhoto != 'img/profile/profile.png'){
                unlink($userPhoto);
            }
        }

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        if(empty($request->password)){
            $request->merge(['password' => $user->password]);
        }

        $user->update($request->all());
        return ['message' => 'Success'];
    }

    public function search(){
        
        if($search = \Request::get('q')){
            $users = User::where(function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('type', 'LIKE', "%$search%");
            })->paginate(5);
        }
        else{
            $users = User::latest()->paginate(5);
        }

        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|unique:users,username,'.$id,
        ]);

        User::where('id', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $user = User::where('id', $id)->first();
        $currentPhoto = $user->photo;
        $userPhoto = public_path('img/profile/').$currentPhoto;
        if('img/profile/'.$currentPhoto != 'img/profile/profile.png'){
            unlink($userPhoto);
        }
        return $find_post = User::find($id)->delete();
    }
}
