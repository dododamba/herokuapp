<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Client;
use App\Admin;
use App\Personnel;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller    UserInfoUpdateController
|
| @author Dominique DAMBA (dominiquedamba@outlook.com)
|
|*/


class UserInfoUpdateController extends Controller
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

    public static function isAdminOrClient($role)
    {
       if ($role == 1 || $role == 2) {
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
            'date_embauche' => $request->date_embauche,
            'date_naissance' => $request->date_naissance,
            'matricule' => $request->matricule,
            'email' => $request->email,
            'role' => $request->role,
            'telephone' => $request->telephone,
            'langue' => $request->langue,    
         ];
         
         
        if (User::where('slug',$request->slug)->first()) {
         $user = User::where('slug',$request->slug)->first();
         $this->user_id = $user->id;

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


         if (self::matches($data_['role'],$data_user['role'])) {
            $this->role = $data_user['role'];
        }else{ 
        $this->role = $data_['role'];
        }

        if (self::matches($data_['telephone'],$data_user['telephone'])) {
            $this->telephone = $data_user['telephone'];
        }else{ 
        $this->telephone = $data_['telephone'];
        }

        if(self::matches($data_['langue'],$data_user['langue'])) {
         $this->langue = $data_user['langue'];
     }else{ 
     $this->langue = $data_['langue'];
     }


     if(self::matches($data_['email'],$data_user['email'])) {
         $this->email = $data_user['email'];
     }else{ 
     $this->email = $data_['email'];
     }

     $this->password = $data_user['password'];
     $this->permissions = $data_user['permissions'];
     $this->last_login = $data_user['last_login'];
     $this->remember_token = $data_user['remember_token'];
     $this->slug_user = $data_user['slug'];     

     $updatable_user = [
        "email"  => $this->email,
        "password"		 => $this->password,
        "permissions"	 => $this->permissions,
        "last_login"  => $this->last_login,
        "remember_token"	 => $this->remember_token,
         "slug"	 => $this->slug_client,
        "langue"		 => $this->langue,
        "telephone"		 => $this->telephone,
        "role"		 => $this->role,
        "created_at"	 => $this->created_at_,
        "updated_at" => Carbon::now()->toDateTimeString()
        
];



         $role = $data_user['role'];

         if (self::isAdminOrClient($role)) {
            if ($role = 1) {
                $id= $this->user_id;
                $admin =  Admin::all();
                return response()->json(['admin'=>$admin]);
                $data_admin = [
                    'nom' => $admin->nom,
                    'prenom' => $admin->prenom,
                    'sexe' => $admin->sexe,
                    'slug' =>$admin->slug, 
                    'date_naissance' => $admin->date_naissance,
                 ];
    
                 
                if (self::matches($data_['nom'],$data_admin['nom'])) {
                    $this->nom = $data_admin['nom'];
                }else{ 
                $this->nom = $data_['nom'];
                }
       
                if (self::matches($data_['prenom'],$data_admin['prenom'])) {
                   $this->prenom = $data_admin['prenom'];
               }else{ 
               $this->prenom = $data_['prenom'];
               }
       
               if (self::matches($data_['sexe'],$data_admin['sexe'])) {
                   $this->sexe = $data_admin['sexe'];
               }else{ 
               $this->sexe = $data_['sexe'];
               }

               
    
               if (self::matches($data_['date_naissance'],$data_admin['date_naissance'])) {
                $this->date_naissance = $data_admin['date_naissance'];
               }else{ 
                $this->date_naissance = $data_['date_naissance'];
               }



                $updatable_admin = [
                    "nom" => $this->nom,
                    "prenom" => $this->prenom,
                    "sexe" => $this->sexe,
                    "slug" => $admin->slug,
                    "date_naissance" => $this->date_naissance,
                    "created_at"	 => $this->created_at,
                    "updated_at" => Carbon::now()->toDateTimeString(),
                    'user' =>  $updatable_user,
                 ];
        
                 return response()->json(['admin' => $updatable_admin]);

            }
            $client = Client::where('user_id',$user->id)->first();     
            $data_client = [
                'nom' => $client->nom,
                'prenom' => $client->prenom,
                'sexe' => $client->sexe,
                'slug' =>$client->slug, 
                'date_naissance' => $client->date_naissance,
             ];

             
            if (self::matches($data_['nom'],$data_client['nom'])) {
                $this->nom = $data_client['nom'];
            }else{ 
            $this->nom = $data_['nom'];
            }
   
            if (self::matches($data_['prenom'],$data_client['prenom'])) {
               $this->prenom = $data_client['prenom'];
           }else{ 
           $this->prenom = $data_['prenom'];
           }
   
           if (self::matches($data_['sexe'],$data_client['sexe'])) {
               $this->sexe = $data_client['sexe'];
           }else{ 
           $this->sexe = $data_['sexe'];
           }

           

           if (self::matches($data_['date_naissance'],$data_client['date_naissance'])) {
            $this->date_naissance = $data_client['date_naissance'];
           }else{ 
            $this->date_naissance = $data_['date_naissance'];
           }



            $updatable_client = [
                "nom" => $this->nom,
                "prenom" => $this->prenom,
                "sexe" => $this->sexe,
                "slug" => $client->slug,
                "date_naissance" => $this->date_naissance,
                "created_at"	 => $this->created_at,
                "updated_at" => Carbon::now()->toDateTimeString(),
                'user' =>  $updatable_user,
             ];
           
            return response()->json(['client' => $updatable_client]);
 
         }
      
         $personnel = Personnel::where('user_id',$user->id)->first();     

         $data_personnel = [
            'nom' => $personnel->nom,
            'prenom' => $personnel->prenom,
            'sexe' => $personnel->sexe,
             'slug' =>$personnel->slug, 
            'date_embauche' => $personnel->date_embauche,
            'date_naissance' => $personnel->date_naissance,
            'matricule' => $personnel->matricule,
         ];


        
       

         
       
         if (self::matches($data_['nom'],$data_personnel['nom'])) {
             $this->nom = $data_personnel['nom'];
         }else{ 
         $this->nom = $data_['nom'];
         }

         if (self::matches($data_['prenom'],$data_personnel['prenom'])) {
            $this->prenom = $data_personnel['prenom'];
        }else{ 
        $this->prenom = $data_['prenom'];
        }

        if (self::matches($data_['sexe'],$data_personnel['sexe'])) {
            $this->sexe = $data_personnel['sexe'];
        }else{ 
        $this->sexe = $data_['sexe'];
        }

     

        if (self::matches($data_['date_embauche'],$data_personnel['date_embauche'])) {
            $this->date_embauche = $data_personnel['date_embauche'];
        }else{ 
        $this->date_embauche = $data_['date_embauche'];
        }

        if (self::matches($data_['matricule'],$data_personnel['matricule'])) {
            $this->matricule = $data_personnel['matricule'];
        }else{ 
        $this->matricule = $data_['matricule'];
        }


        if (self::matches($data_['date_naissance'],$data_personnel['date_naissance'])) {
            $this->date_naissance = $data_personnel['date_naissance'];
        }else{ 
        $this->date_naissance = $data_['date_naissance'];
        }


        $updatable_personnel = [
            "nom" => $this->nom,
            "prenom" => $this->prenom,
            "sexe" => $this->sexe,
            "slug" => $this->slug_client,
            "date_naissance" => $this->date_naissance,
            "date_embauche" =>$this->date_embauche,
            "matricule" =>$this->matricule ,
            'user' => $updatable_user      
         ];
        /* 
         if ($user->update($data_)) {
            return response()->json(['message' => 'Mot de pass mise à jours avec succès']);
         }*/
          return response()->json(['error' =>$updatable_personnel]);

        }
        return response()->json(['error' => 'Echec mise à jours mot de pass ,l\'utilisateur n\'existe pas!']);

    }


    

}
