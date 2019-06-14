<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\PositionAnnonce as PositionAnnonceResource;
use App\PositionAnnonce;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   PositionAnnonceController
|
|
|
|*/


class PositionAnnonceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!PositionAnnonceResource::collection(PositionAnnonce::paginate(10))->isEmpty()){
                   fetchLog(PositionAnnonce::class);
                    return response()->json(['content'=>PositionAnnonce::orderBy('created_at','desc')->paginate(10),'message'=>'liste des PositionAnnonces'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(PositionAnnonce::class);
                return response()->json(['message'=>'PositionAnnonces empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

       $data = [
         'libelle'=>$request->libelle,
         'slug' =>str_slug(name_generator('position-annonce',10),'-')
       ];

       if (PositionAnnonce::create($data)) {
                 createLog(PositionAnnonce::class);
                  return response()->json(['message' => ' PositionAnnonce crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( PositionAnnonce::class);
       return response()->json(['message'=>'echec de création PositionAnnonce']);
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
            if (PositionAnnonce::where('slug','=',$slug)->first()){
            $id = PositionAnnonce::where('slug','=',$slug)->first()->id;
            showLog(PositionAnnonce::class,$id);
            return response()->json(['content'=>new PositionAnnonceResource(PositionAnnonce::where('slug','=',$slug)->first()),'message'=>'détail PositionAnnonce'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(PositionAnnonce::class,$id);
          return response()->json(['message' => 'echec ,PositionAnnonce n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (PositionAnnonce::where('slug','=',$slug)->first()){
           $positionannonce = PositionAnnonce::where('slug','=',$slug)->first();
           $data = [
             'libelle'=>$request->libelle,
             'slug' =>str_slug(name_generator('position-annonce',10),'-')
           ];
           if ($positionannonce->update($data)){
               $positionannonce =PositionAnnonce::where('slug','=',$slug)->first();
               updateLog(PositionAnnonce::class,$positionannonce->id);
               return response()->json(['message' => ' PositionAnnonce mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(PositionAnnonce::class,$positionannonce->id);
          return response()->json(['message' => ' echec mise à jours PositionAnnonce  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(PositionAnnonce::class,setZero());
      return response()->json(['message' => ' PositionAnnonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (PositionAnnonce::where('slug','=',$slug)->first()){
                    $positionannonce = PositionAnnonce::where('slug','=',$slug)->first();
                    $positionannonce->delete();
                    deleteLog(PositionAnnonce::class,$id);
                    return response()->json(['message' => ' PositionAnnonce supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(PositionAnnonce::class,setZero());
        return response()->json(['message' => ' PositionAnnonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
