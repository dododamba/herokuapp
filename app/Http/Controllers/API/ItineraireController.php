<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Itineraire as ItineraireResource;
use App\Itineraire;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ItineraireController
|
|
|
|*/


class ItineraireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!ItineraireResource::collection(Itineraire::paginate(10))->isEmpty()){
                   fetchLog(Itineraire::class);
                    return response()->json(['content'=>Itineraire::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Itineraires'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Itineraire::class);
                return response()->json(['message'=>'Itineraires empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

       $data = ['ville_depart' =>$request->ville_depart, 'ville_arrivee'=>$request->ville_arrivee, 'description'=>$request->description,'slug'=>str_slug(name_generator('itineraire',10),'-')];
       if (Itineraire::create($data)) {
                 createLog(Itineraire::class);
                  return response()->json(['message' => ' Itineraire crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( Itineraire::class);
       return response()->json(['message'=>'echec de création Itineraire']);
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
            if (Itineraire::where('slug','=',$slug)->first()){
            $id = Itineraire::where('slug','=',$slug)->first()->id;
            showLog(Itineraire::class,$id);
            return response()->json(['content'=>new ItineraireResource(Itineraire::where('slug','=',$slug)->first()),'message'=>'détail Itineraire'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Itineraire::class,$id);
          return response()->json(['message' => 'echec ,Itineraire n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (Itineraire::where('slug','=',$slug)->first()){
           $itineraire = Itineraire::where('slug','=',$slug)->first();
           $data = ['ville_depart' =>$request->ville_depart, 'ville_arrivee'=>$request->ville_arrivee, 'description'=>$request->description,'slug'=>str_slug(name_generator('itineraire',10),'-')];
           if ($itineraire->update($data)){
               $itineraire =Itineraire::where('slug','=',$slug)->first();
               updateLog(Itineraire::class,$itineraire->id);
               return response()->json(['message' => ' Itineraire mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Itineraire::class,$itineraire->id);
          return response()->json(['message' => ' echec mise à jours Itineraire  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Itineraire::class,setZero());
      return response()->json(['message' => ' Itineraire n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Itineraire::where('slug','=',$slug)->first()){
                    $itineraire = Itineraire::where('slug','=',$slug)->first();
                    $itineraire->delete();
                    deleteLog(Itineraire::class,$id);
                    return response()->json(['message' => ' Itineraire supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Itineraire::class,setZero());
        return response()->json(['message' => ' Itineraire n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
