<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Rules\PhoneNumber;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            $viewName = $request->path();
            if ($viewName === 'pages-profile-settings') {
                $countries = Country::all();
                $user = Auth::user(); // Assuming you are using Laravel's authentication and user retrieval
    
                // Define required fields
                $requiredFields = ['name', 'email', 'contact','avatar']; // Update with your actual required fields
    
                // Calculate filled fields
                $filledFieldsCount = 0;
    
                foreach ($requiredFields as $field) {
                    if (!empty($user->$field)) {
                        $filledFieldsCount++;
                    }
                }
    
                // Calculate percentage completion
                $totalRequiredFields = count($requiredFields);
                $profileCompletionPercentage = ($filledFieldsCount / $totalRequiredFields) * 100;
    
                // Round to two decimal places
                $profileCompletionPercentage = round($profileCompletionPercentage, 2);
    
                // Pass the percentage variable to the view
                return view($viewName, [
                    'profileCompletionPercentage' => $profileCompletionPercentage,
                    'user' => $user,
                    'countries' => $countries,
                ]);
            }
            return view($viewName);
        }
        return abort(404);
    }

    public function root()
    {
        return view('index');
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
       $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255','min:3'],
            'email' => ['required','email','unique:users,email,' . Auth::user()->id,],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'contact' => ['required', 'string', new PhoneNumber($request->get('region_code'))],
            'region_code' => ['required', 'exists:countries,phone_code'],
    
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->contact = $request->get('contact');
        $user->region_code = $request->get('region_code');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "User Details Updated successfully!"
            // ], 200); // Status code here
            return redirect()->back();
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "Something went wrong!"
            // ], 200); // Status code here
            return redirect()->back();

        }
    }

    // public function updatePassword(Request $request, $id)
    // {
    //     $request->validate([
    //         'current_password' => ['required', 'string'],
    //         'password' => ['required', 'string', 'min:6', 'confirmed'],
    //     ]);

    //     if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
    //         return response()->json([
    //             'isSuccess' => false,
    //             'Message' => "Your Current password does not matches with the password you provided. Please try again."
    //         ], 200); // Status code
    //     } else {
    //         $user = User::find($id);
    //         $user->password = Hash::make($request->get('password'));
    //         $user->update();
    //         if ($user) {
    //             Session::flash('message', 'Password updated successfully!');
    //             Session::flash('alert-class', 'alert-success');
    //             return response()->json([
    //                 'isSuccess' => true,
    //                 'Message' => "Password updated successfully!"
    //             ], 200); // Status code here
    //         } else {
    //             Session::flash('message', 'Something went wrong!');
    //             Session::flash('alert-class', 'alert-danger');
    //             return response()->json([
    //                 'isSuccess' => true,
    //                 'Message' => "Something went wrong!"
    //             ], 200); // Status code here
    //         }
    //     }
    // }

    public function updatePassword(Request $request, $id)
{
    $request->validate([
        'current_password' => ['required', 'string'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

    if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
        if ($request->ajax()) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your current password does not match the password you provided. Please try again."
            ], 200);
        } else {
            Session::flash('message', 'Your current password does not match the password you provided. Please try again.');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    } else {
        $user = User::find($id);
        $user->password = Hash::make($request->get('password'));
        $user->update();

        if ($user) {
            if ($request->ajax()) {
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200);
            } else {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return redirect()->back();
            }
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'isSuccess' => false,
                    'Message' => "Something went wrong!"
                ], 200);
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        }
    }
}

}
