<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['required', 'image' ,'mimes:jpg,jpeg,png','max:1024'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // return request()->file('avatar');
        if (request()->has('avatar')) {
            $avatar = request()->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar' =>  $avatarName,
        ]);
    }

    // public function updateProfileImage(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'avatar' => ['required', 'image' ,'mimes:jpg,jpeg,png','max:1024'],
    //     ]);
    //     if($validator->fails()) {
    //     Session::flash('message', $validator->errors());
    //     Session::flash('alert-class', 'alert-danger');
    //     return redirect()->back();
    //     }
    //     $user = User::findOrFail($id);
    //     $oldAvatar = $user->avatar;
       
    //     if ($request->hasFile('avatar')) {
    //         $avatar = request()->file('avatar');
    //         $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
    //         $avatarPath = public_path('/images/');
    //         $avatar->move($avatarPath, $avatarName);

    //         $user->avatar = $avatarName;
    //         $user->save();

    //         // Delete old avatar if it's not the default one
    //         if ($oldAvatar != 'avatar-1.jpg') {
    //             Storage::delete('images/' . $oldAvatar);
    //         }

    //         Session::flash('message', 'Profile image updated successfully!');
    //         Session::flash('alert-class', 'alert-success');
    //         return redirect()->back();
    //     }

    //     Session::flash('message', 'Please select a valid image.');
    //     Session::flash('alert-class', 'alert-danger');
    //     return redirect()->back();
    // }

   
}
