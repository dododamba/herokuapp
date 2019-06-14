<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\DemandePartenaire as DemandePartenaireResource;
use App\DemandePartenaire;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   DemandePartenaireController
|
|
|
|*/


class DemandePartenaireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!DemandePartenaireResource::collection(DemandePartenaire::paginate(10))->isEmpty()){
                   fetchLog(DemandePartenaire::class);
                    return response()->json(['content'=>DemandePartenaire::orderBy('created_at','desc')->paginate(10),'message'=>'liste des DemandePartenaires'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(DemandePartenaire::class);
                return response()->json(['message'=>'DemandePartenaires empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = ['adresse'=>$request->adresse, 'description'=>$request->description, 'slug'=>str_slug(name_generator('demande-partenaire',10),'-'),'logo'=>$request->logo, 'etat'=>$request->etat, 'code_activation'=>$request->code_activation, 'type_partenaire'=>$request->type_partenaire, 'etat_traitement'=>$request->etat_traitement,
       'utilisateur'=>$request->utilisateur];

       if (DemandePartenaire::create($data)) {
                 createLog(DemandePartenaire::class);
                  return response()->json(['message' => ' DemandePartenaire crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( DemandePartenaire::class);
       return response()->json(['message'=>'echec de création DemandePartenaire']);
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
          if (DemandePartenaire::where('slug','=',$slug)->first()){
           $demandepartenaire = DemandePartenaire::where('slug','=',$slug)->first();
           $data = ['adresse'=>$request->adresse, 'description'=>$request->description, 'slug'=>str_slug(name_generator('demande-partenaire',10),'-'),'logo'=>$request->logo, 'etat'=>$request->etat, 'code_activation'=>$request->code_activation, 'type_partenaire'=>$request->type_partenaire, 'etat_traitement'=>$request->etat_traitement,
           'utilisateur'=>$request->utilisateur];

           if ($demandepartenaire->update($data)){
               $demandepartenaire =DemandePartenaire::where('slug','=',$slug)->first();
               updateLog(DemandePartenaire::class,$demandepartenaire->id);
               return response()->json(['message' => ' DemandePartenaire mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(DemandePartenaire::class,$demandepartenaire->id);
          return response()->json(['message' => ' echec mise à jours DemandePartenaire  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(DemandePartenaire::class,setZero());
      return response()->json(['message' => ' DemandePartenaire n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (DemandePartenaire::where('slug','=',$slug)->first()){
                    $demandepartenaire = DemandePartenaire::where('slug','=',$slug)->first();
                    $demandepartenaire->delete();
                    deleteLog(DemandePartenaire::class);
                    return response()->json(['message' => ' DemandePartenaire supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(DemandePartenaire::class,setZero());
        return response()->json(['message' => ' DemandePartenaire n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
