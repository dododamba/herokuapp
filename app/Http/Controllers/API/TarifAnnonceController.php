<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\TarifAnnonce as TarifAnnonceResource;
use App\TarifAnnonce;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   TarifAnnonceController
|
|
|
|*/


class TarifAnnonceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!TarifAnnonceResource::collection(TarifAnnonce::paginate(10))->isEmpty()){
                   fetchLog(TarifAnnonce::class);
                    return response()->json(['content'=>TarifAnnonce::orderBy('created_at','desc')->paginate(10),'message'=>'liste des TarifAnnonces'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(TarifAnnonce::class);
                return response()->json(['message'=>'TarifAnnonces empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data =  [
         'prix_image' =>$request->prix_image,
         'prix_caractere' =>$request->prix_caractere,
         'position' =>$request->position,
         'annoce' =>$request->annoce,
         'slug' =>str_slug(name_generator('tarif-annoce',10),'-')
       ];


       if (TarifAnnonce::create($data)) {
                 createLog(TarifAnnonce::class);
                  return response()->json(['message' => ' TarifAnnonce crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( TarifAnnonce::class);
       return response()->json(['message'=>'echec de création TarifAnnonce']);
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
            if (TarifAnnonce::where('slug','=',$slug)->first()){
            $id = TarifAnnonce::where('slug','=',$slug)->first()->id;
            showLog(TarifAnnonce::class,$id);
            return response()->json(['content'=>new TarifAnnonceResource(TarifAnnonce::where('slug','=',$slug)->first()),'message'=>'détail TarifAnnonce'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(TarifAnnonce::class,$id);
          return response()->json(['message' => 'echec ,TarifAnnonce n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (TarifAnnonce::where('slug','=',$slug)->first()){
           $tarifannonce = TarifAnnonce::where('slug','=',$slug)->first();
           $data =  [
             'prix_image' =>$request->prix_image,
             'prix_caractere' =>$request->prix_caractere,
             'position' =>$request->position,
             'annoce' =>$request->annoce,
             'slug' =>str_slug(name_generator('tarif-annoce',10),'-')
           ];

           if ($tarifannonce->update($data)){
               $tarifannonce =TarifAnnonce::where('slug','=',$slug)->first();
               updateLog(TarifAnnonce::class,$tarifannonce->id);
               return response()->json(['message' => ' TarifAnnonce mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(TarifAnnonce::class,$tarifannonce->id);
          return response()->json(['message' => ' echec mise à jours TarifAnnonce  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(TarifAnnonce::class,setZero());
      return response()->json(['message' => ' TarifAnnonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (TarifAnnonce::where('slug','=',$slug)->first()){
                    $tarifannonce = TarifAnnonce::where('slug','=',$slug)->first();
                    $tarifannonce->delete();
                    deleteLog(TarifAnnonce::class,$id);
                    return response()->json(['message' => ' TarifAnnonce supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(TarifAnnonce::class,setZero());
        return response()->json(['message' => ' TarifAnnonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
