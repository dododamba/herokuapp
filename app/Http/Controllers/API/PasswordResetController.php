<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function reset(Request $request)
    {
  

        $rules = [
            'password' => 'required|string|min:2|max:100|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|string|min:2|max:100',         
         ];
 
         $messages = [
             'password.required' => 'Le champ password est obligatoire !',
             'password.string' => 'Le champ password doit contenir des chaines de charactères !',
             'password.min' => 'Le champ password doit contenir au moins deux charactères !',
             'password.max' => 'Le champ password ne doit pas exceder 100 charactères !', 
             'password.same' => 'Les mots de pass saisie ne correspondent pas !',
             'password_confirmation.required' => 'Veuillez confirmer le mot de pass',
         
         ];
 
         $validator = Validator::make($request->all(), $rules,$messages);

         if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
         }
         


        
        if (User::where('slug',$request->slug)->first()) {
            $user = User::where('slug',$request->slug)->first();

         $data_ = [
            'email' => $user->email,
            'role' => $user->role,
            'telephone' => $user->telephone,
            'langue' => $user->langue,
            'slug' => $user->slug,
            'permissions'=> $user->permissions,
            'last_login' => $user->last_login,
            'password' => Hash::make($request->password),
            'created_at'=> $user->created_at,
            'remember_token' => $user->remember_token,
            'updated_at'=> Carbon::now()->toDateTimeString()

        ];
        
         if ($user->update($data_)) {
            return response()->json(['message' => 'Mot de pass mise à jours avec succès']);
          }
          return response()->json(['error' =>  'Echec mise à jours mot de pass !']);

        }
        return response()->json(['error' => 'Echec mise à jours mot de pass ,l\'utilisateur n\'existe pas!']);


    }

}
