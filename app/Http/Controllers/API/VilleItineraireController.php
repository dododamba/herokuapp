<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\VilleItineraire as VilleItineraireResource;
use App\VilleItineraire;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   VilleItineraireController
|
|
|
|*/


class VilleItineraireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!VilleItineraireResource::collection(VilleItineraire::paginate(10))->isEmpty()){
                   fetchLog(VilleItineraire::class);
                    return response()->json(['content'=>VilleItineraire::orderBy('created_at','desc')->paginate(10),'message'=>'liste des VilleItineraires'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(VilleItineraire::class);
                return response()->json(['message'=>'VilleItineraires empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

      $data = [
        'rang' =>$request->rang,
        'ville' =>$request->ville,
        'itineraire' =>$request->itineraire,
        'escale' =>$request->escale,
        'slug' =>str_slug(name_generator('ville-itineraire',10),'-')
      ];

       if (VilleItineraire::create($data)) {
                 createLog(VilleItineraire::class);
                  return response()->json(['message' => ' VilleItineraire crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( VilleItineraire::class);
       return response()->json(['message'=>'echec de création VilleItineraire']);
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
            if (VilleItineraire::where('slug','=',$slug)->first()){
            $id = VilleItineraire::where('slug','=',$slug)->first()->id;
            showLog(VilleItineraire::class,$id);
            return response()->json(['content'=>new VilleItineraireResource(VilleItineraire::where('slug','=',$slug)->first()),'message'=>'détail VilleItineraire'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(VilleItineraire::class,$id);
          return response()->json(['message' => 'echec ,VilleItineraire n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (VilleItineraire::where('slug','=',$slug)->first()){
           $villeitineraire = VilleItineraire::where('slug','=',$slug)->first();
           $data = [
             'rang' =>$request->rang,
             'ville' =>$request->ville,
             'itineraire' =>$request->itineraire,
             'escale' =>$request->escale,
             'slug' =>str_slug(name_generator('ville-itineraire',10),'-')
           ];
           if ($villeitineraire->update($data)){
               $villeitineraire =VilleItineraire::where('slug','=',$slug)->first();
               updateLog(VilleItineraire::class,$villeitineraire->id);
               return response()->json(['message' => ' VilleItineraire mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(VilleItineraire::class,$villeitineraire->id);
          return response()->json(['message' => ' echec mise à jours VilleItineraire  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(VilleItineraire::class,setZero());
      return response()->json(['message' => ' VilleItineraire n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (VilleItineraire::where('slug','=',$slug)->first()){
                    $villeitineraire = VilleItineraire::where('slug','=',$slug)->first();
                    $villeitineraire->delete();
                    deleteLog(VilleItineraire::class,$id);
                    return response()->json(['message' => ' VilleItineraire supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(VilleItineraire::class,setZero());
        return response()->json(['message' => ' VilleItineraire n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
