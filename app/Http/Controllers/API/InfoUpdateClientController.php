<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;


use App\User;
use App\Client;
use Carbon\Carbon;
class InfoUpdateClientController extends Controller
{
    private $nom;
    private $prenom;
    private $sexe;
    private $email;
    private $role;
    private $telephone;
    private $langue;   
    //
    private $matricule;     
    private $date_embauche;
    private $date_naissance;
    // 
    private $password;
    private $permissions;
    private $last_login;
    private $remember_token;
    private $slug_user;     
    private $slug_client;   
    private $created_at_;
    private $created_at;
    private $user_id;


private static function matches($needle, $haystack)
{
    if ($needle === $haystack) {
       return true;
    }
    return false;
}



public function update(Request $request)
{
    $data_ = [
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'sexe' => $request->sexe,
        'role' => $request->role,
        'email' => $request->email,
        'role' => $request->role,
        'telephone' => $request->telephone,
        'langue' => $request->langue,   
        'date_naissance' => $request->date_naissance 
     ];
     
    $rules = [
        'nom' => 'required|string|min:2|max:100',
        'prenom' => 'required|string|min:2|max:100',
        'email' => 'required|string|email',
        'date_naissance' => 'date',
        'role' => 'required|integer|in:2',
    

     ];

     $messages = [
         'nom.required' => 'Le champ nom est obligatoire !',
         'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
         'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
         'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
         'prenom.required' => 'Le champ nom est obligatoire !',
         'prenom.string' => 'Le champ nom doit contenir des chaines de charactères !',
         'prenom.min' => 'Le champ nom doit contenir au moins deux charactères !',
         'prenom.required' => 'Le champ prenom doit contenir au plus cent charactères !',
         'prenom.max' => 'Le champ prenom ne doit pas exceder 100 charactères !',
         'email.required' => 'Le champ  email est obligatoire ! ',
         'email.email' => 'L\'adresse email est invalide',
         'date_naissance.date' => 'La date de naissance est invalide',
         'role.integer' => 'le role est invalide',
         'role.required' => 'Le role est obligatoire',
         'role.in' =>'Le role choisit est irrecevable'
     ];

     $validator = Validator::make($request->all(), $rules,$messages);

     if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()]);
     }


 
     
     
    if (User::where('slug',$request->slug)->first()) {
     $user = User::where('slug',$request->slug)->first();
     $this->user_id = $user->id;
     $admin = Client::where('user_id',$user->id)->first();     

     $data_admin = [
        'nom' => $admin->nom,
        'prenom' => $admin->prenom,
        'sexe' => $admin->sexe,
        'slug' =>$admin->slug, 
        'date_naissance' => $admin->date_naissance,
     ];


     
     $data_user = [
        'email' => $user->email,
        'role' => $user->role,
        'telephone' => $user->telephone,
        'langue' => $user->langue,    
        'password' => $user->password,
        "permissions"	 => $user->permissions,
        "last_login"  => $user->last_login,
        "remember_token"	 => $user->remember_token,
        "slug"	 => $user->slug_client,
        "langue"		 => $user->langue,
        "telephone"		 => $user->telephone,
        "role"		 => $user->role,
        "created_at"	 => $user->created_at,
     ];

      // admin 
      
      if (self::matches($data_['nom'],$data_admin['nom'])) {
        $this->nom = $data_admin['nom'];
      }
     elseif(!$request->has('nom')){
        $this->nom = $data_admin['nom'];
      }
      else{
          $this->nom = $data_['nom'];
      }
           
      
       
      if (self::matches($data_['date_naissance'],$data_admin['date_naissance'])) {
        $this->date_naissance = $data_admin['date_naissance'];
      }
     elseif(!$request->has('date_naissance')){
        $this->date_naissance = $data_admin['date_naissance'];
      }
      else{
          $this->date_naissance = $data_['date_naissance'];
      }



         if (self::matches($data_['prenom'],$data_admin['prenom'])) {
            $this->prenom = $data_admin['prenom'];
          }
         elseif(!$request->has('prenom')){
            $this->prenom = $data_admin['prenom'];
          }
          else{
              $this->prenom = $data_['prenom'];
          }
      
          if (self::matches($data_['sexe'],$data_admin['sexe'])) {
            $this->sexe = $data_admin['sexe'];
          }
         elseif(!$request->has('sexe')){
            $this->sexe = $data_admin['sexe'];
          }
          else{
              $this->sexe = $data_['sexe'];
          }
          

     if (self::matches($data_['role'],$data_user['role'])) {
        $this->role = $data_user['role'];
      }
     elseif(!$request->has('role')){
        $this->role = $data_user['role'];
      }
      else{
          $this->role = $data_['role'];
      }


      if (self::matches($data_['telephone'],$data_user['telephone'])) {
        $this->telephone = $data_user['telephone'];
      }
     elseif(!$request->has('telephone')){
        $this->telephone = $data_user['telephone'];
      }
      else{
          $this->telephone = $data_['telephone'];
      }


    
      if (self::matches($data_['langue'],$data_user['langue'])) {
        $this->langue = $data_user['langue'];
      }
     elseif(!$request->has('langue')){
        $this->langue = $data_user['langue'];
      }
      else{
          $this->langue = $data_['langue'];
      }
   
      if (self::matches($data_['email'],$data_user['email'])) {
        $this->email = $data_user['email'];
      }
     elseif(!$request->has('email')){
        $this->email = $data_user['email'];
      }
      else{
          $this->email = $data_['email'];
      }

      

    $this->password = $data_user['password'];
    $this->permissions = $data_user['permissions'];
    $this->last_login = $data_user['last_login'];
    $this->remember_token = $data_user['remember_token'];
    $this->slug_user = $data_user['slug'];     


 $updatable_admin = [
    "nom" => $this->nom,
    "prenom" => $this->prenom,
    "sexe" => $this->sexe,
    "slug" => str_randomize(10),
    "date_naissance" => $this->date_naissance,
    "created_at"	 => $this->created_at,
    "updated_at" => Carbon::now()->toDateTimeString(),
 ];

 $updatable_user = [
    "email"  => $this->email,
    "password"		 => $this->password,
    "permissions"	 => $this->permissions,
    "last_login"  => $this->last_login,
    "remember_token"	 => $this->remember_token,
    "slug"	 => str_randomize(10),
    "langue"		 => $this->langue,
    "telephone"		 => $this->telephone,
    "role"		 => $this->role,
    "created_at"	 => $this->created_at_,
    "updated_at" => Carbon::now()->toDateTimeString(),        
    ];


    if ($user->update($updatable_user) && $admin->update($updatable_admin)) {
        return response()->json(['message' => 'Compte mise à jours avec succès !']);
    }
    return response()->json(['error' => 'Echec mise à jours recommencez svp !']);

    }
    return response()->json(['error' => 'Ce utilisateur n\'existe pas , vueillez recommencer!']);

}
}
