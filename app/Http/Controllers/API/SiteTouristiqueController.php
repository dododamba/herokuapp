<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\SiteTouristique as SiteTouristiqueResource;
use App\SiteTouristique;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   SiteTouristiqueController
|
|
|
|*/


class SiteTouristiqueController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!SiteTouristiqueResource::collection(SiteTouristique::paginate(10))->isEmpty()){
                   fetchLog(SiteTouristique::class);
                    return response()->json(['content'=>SiteTouristique::orderBy('created_at','desc')->paginate(10),'message'=>'liste des SiteTouristiques'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(SiteTouristique::class);
                return response()->json(['message'=>'SiteTouristiques empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
      $data = [
        'nom' =>$request->nom,
        'longitude' =>$request->longitude,
        'latitude' =>$request->latitude,
        'description' =>$request->description,
        'etat' =>$request->etat,
        'ville' =>$request->ville,
        'decoupage_trois' =>$request->decoupage_trois,
        'slug' =>str_slug(name_generator('site-touristique',10),'-')

      ];

        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'nom' => 'required|string|min:2',
        ];

        $messages = [
            'nom.required' => 'Le champ nom est obligatoire !',
            'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'nom.min' => 'Le champ nom doit contenir au moins deux charactères !'

        ];

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors(),
                    'status' => $assert_false,
                    'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                ]
            );
        }
       if (SiteTouristique::create($data)) {
                 createLog(SiteTouristique::class);
                  return response()->json(['message' => ' SiteTouristique crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( SiteTouristique::class);
       return response()->json(['message'=>'echec de création SiteTouristique']);
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
            if (SiteTouristique::where('slug','=',$slug)->first()){
            $id = SiteTouristique::where('slug','=',$slug)->first()->id;
            showLog(SiteTouristique::class,$id);
            return response()->json(['content'=>new SiteTouristiqueResource(SiteTouristique::where('slug','=',$slug)->first()),'message'=>'détail SiteTouristique'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(SiteTouristique::class,$id);
          return response()->json(['message' => 'echec ,SiteTouristique n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (SiteTouristique::where('slug','=',$slug)->first()){
           $sitetouristique = SiteTouristique::where('slug','=',$slug)->first();
           $data = [
             'nom' =>$request->nom,
             'longitude' =>$request->longitude,
             'latitude' =>$request->latitude,
             'description' =>$request->description,
             'etat' =>$request->etat,
             'ville' =>$request->ville,
             'decoupage_trois' =>$request->decoupage_trois,
             'slug' =>str_slug(name_generator('site-touristique',10),'-')

           ];
           if ($sitetouristique->update($data)){
               $sitetouristique =SiteTouristique::where('slug','=',$slug)->first();
               updateLog(SiteTouristique::class,$sitetouristique->id);
               return response()->json(['message' => ' SiteTouristique mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(SiteTouristique::class,$sitetouristique->id);
          return response()->json(['message' => ' echec mise à jours SiteTouristique  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(SiteTouristique::class,setZero());
      return response()->json(['message' => ' SiteTouristique n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (SiteTouristique::where('slug','=',$slug)->first()){
                    $sitetouristique = SiteTouristique::where('slug','=',$slug)->first();
                    $sitetouristique->delete();
                    deleteLog(SiteTouristique::class,$id);
                    return response()->json(['message' => ' SiteTouristique supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(SiteTouristique::class,setZero());
        return response()->json(['message' => ' SiteTouristique n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
