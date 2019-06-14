<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\User as UtilisateurResource;
use App\User;
use App\Utilisateur;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   UserController
|
|
|
|*/


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {


                if(!UtilisateurResource::collection(Utilisateur::paginate(10))->isEmpty()){
                   fetchLog(Utilisateur::class);
                    return response()->json(['content'=>User::whereHas('roles', function($query) {
                        $query->where('name', 'client');
                    })->get(),'message'=>'liste des clients'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Utilisateur::class);
                return response()->json(['message'=>'Utilisateurs empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
      $data = [
        'email' =>$request->email,
        'pseudo' =>$request->pseudo,
        'mot_de_pass' =>$request->mot_de_pass,
        'langue' =>$request->langue,
        'code_activation' =>$request->code_activation,
        'code_reinitialisation' =>$request->code_reinitialisation,
        'slug' =>str_slug(name_generator('utilisateur',10),'-')
      ];

       if (Utilisateur::create($data)) {
                 createLog(Utilisateur::class);
                  return response()->json(['message' => ' User crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( Utilisateur::class);
       return response()->json(['message'=>'echec de création User']);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function show(Request $request,$slug)
     {
            if (Utilisateur::where('slug','=',$slug)->first()){
            $id = Utilisateur::where('slug','=',$slug)->first()->id;
            showLog(Utilisateur::class,$id);
            return response()->json(['content'=>new UtilisateurResource(Utilisateur::where('slug','=',$slug)->first()),'message'=>'détail User'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Utilisateur::class,$id);
          return response()->json(['message' => 'echec ,User n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function update(Request $request,$slug)
    {
          if (Utilisateur::where('slug','=',$slug)->first()){
           $utilisateur = Utilisateur::where('slug','=',$slug)->first();
           $data = [
             'email' =>$request->email,
             'pseudo' =>$request->pseudo,
             'mot_de_pass' =>$request->mot_de_pass,
             'langue' =>$request->langue,
             'code_activation' =>$request->code_activation,
             'code_reinitialisation' =>$request->code_reinitialisation,
             'slug' =>str_slug(name_generator('utilisateur',10),'-')
           ];

           if ($utilisateur->update($data)){
               $utilisateur =Utilisateur::where('slug','=',$slug)->first();
               updateLog(Utilisateur::class,$utilisateur->id);
               return response()->json(['message' => ' User mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Utilisateur::class,$utilisateur->id);
          return response()->json(['message' => ' echec mise à jours User  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Utilisateur::class,setZero());
      return response()->json(['message' => ' User n\'existe pas !'],404,['Content-Type'=>'application/json']);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function destroy(Request $request,$slug)
     {
              if (Utilisateur::where('slug','=',$slug)->first()){
                    $utilisateur = Utilisateur::where('slug','=',$slug)->first();
                    $utilisateur->delete();
                    deleteLog(Utilisateur::class,$id);
                    return response()->json(['message' => ' User supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Utilisateur::class,setZero());
        return response()->json(['message' => ' User n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
