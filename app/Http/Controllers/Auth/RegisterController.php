<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Redirect;
use Sentinel;
use Session;
use Activation;
use App\Client;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    

    use RegistersUsers;

    /**
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

   

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request){

        $validation = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

         if ($validation->fails()) {
                return Redirect::back()->withErrors($validation)->withInput();
         }

         $data_user = [
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'slug'=>str_slug(name_generator('client',10),'-'),
            'langue'=>'Fr',
            'telephone' => '',
            'remember_token'=>str_slug(name_generator('token',50),'_'),
            'role' => 2
         ];
         $user = User::create($data_user);
         
         if (User::where('slug',$data_user['slug'])->first()) {
            $user_ = User::where('slug',$data_user['slug'])->first();
            $data = [
                'nom'=>$request->first_name,
                'prenom' =>$request->last_name,
                'slug' =>str_slug(name_generator('client',30),'_'),
                'user_id' =>$user_->id,
               ];
      
               Client::create($data);
               //Activate the user ** 
           $activation = Activation::create($user);
        // $activation = Activation::complete($user, $activation->code);
        //End activation

        if($user){
            $user->roles()->sync([2]); // 2 = client
            Session::flash('message', 'Registration is completed');
            Session::flash('status', 'success');
           return redirect('/'); 
        }
         Session::flash('message', 'There was an error with the registration' );
         Session::flash('status', 'error');
         return Redirect::back();
         }
         

        
    }



}
