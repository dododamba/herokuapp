<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Location as LocationResource;
use App\Location;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   LocationController
|
|
|
|*/


class LocationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!LocationResource::collection(Location::paginate(10))->isEmpty()){
                   fetchLog(Location::class);
                    return response()->json(['content'=>Location::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Locations'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Location::class);
                return response()->json(['message'=>'Locations empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = ['titre' =>$request->titre, 'description'=>$request->description, 'date_debut_disponibilite'=>$request->date_debut_disponibilite,
       'slug'=>str_slug(name_generator('location',10),'-'), 'date_fin_disponibilite'=>$request->date_fin_disponibilite, 'etat'=>$request->etat];
        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'titre' => 'required|string|min:2',
        ];

        $messages = [
            'titre.required' => 'Le champ titre est obligatoire !',
            'titre.string' => 'Le champ titre doit contenir des chaines de charactères !',
            'titre.min' => 'Le champ titre doit contenir au moins deux charactères !'

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
       if (Location::create($data)) {
                 createLog(Location::class);
                  return response()->json(['message' => ' Location crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( Location::class);
       return response()->json(['message'=>'echec de création Location']);
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
            if (Location::where('slug','=',$slug)->first()){
            $id = Location::where('slug','=',$slug)->first()->id;
            showLog(Location::class,$id);
            return response()->json(['content'=>new LocationResource(Location::where('slug','=',$slug)->first()),'message'=>'détail Location'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Location::class,$id);
          return response()->json(['message' => 'echec ,Location n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (Location::where('slug','=',$slug)->first()){
           $location = Location::where('slug','=',$slug)->first();
           $data = ['titre' =>$request->titre, 'description'=>$request->description, 'date_debut_disponibilite'=>$request->date_debut_disponibilite,
           'slug'=>str_slug(name_generator('location',10),'-'), 'date_fin_disponibilite'=>$request->date_fin_disponibilite, 'etat'=>$request->etat];

           if ($location->update($data)){
               $location =Location::where('slug','=',$slug)->first();
              updateLog(Location::class,$location->id);
               return response()->json(['message' => ' Location mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Location::class,$location->id);
          return response()->json(['message' => ' echec mise à jours Location  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Location::class,setZero());
      return response()->json(['message' => ' Location n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Location::where('slug','=',$slug)->first()){
                    $location = Location::where('slug','=',$slug)->first();
                    $location->delete();
                    deleteLog(Location::class,$id);
                    return response()->json(['message' => ' Location supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Location::class,setZero());
        return response()->json(['message' => ' Location n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
