<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\ModeFacturation as ModeFacturationResource;
use App\ModeFacturation;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ModeFacturationController
|
|
|
|*/


class ModeFacturationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!ModeFacturationResource::collection(ModeFacturation::paginate(10))->isEmpty()){
                   fetchLog(ModeFacturation::class);
                    return response()->json(['content'=>ModeFacturation::orderBy('created_at','desc')->paginate(10),'message'=>'liste des ModeFacturations'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(ModeFacturation::class);
                return response()->json(['message'=>'ModeFacturations empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
      $data =  [
        'libelle'=>$request->libelle,
        'description'=>$request->description,
        'slug'=>str_slug(name_generator('mode-facturation',10),'-')
      ];

        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'libelle' => 'required|string|min:2',
        ];

        $messages = [
            'libelle.required' => 'Le champ libelle est obligatoire !',
            'libelle.string' => 'Le champ libelle doit contenir des chaines de charactères !',
            'libelle.min' => 'Le champ nom doit contenir au moins deux charactères !'

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
       if (ModeFacturation::create($data)) {
                 createLog(ModeFacturation::class);
                  return response()->json(['message' => ' ModeFacturation crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( ModeFacturation::class);
       return response()->json(['message'=>'echec de création ModeFacturation']);
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

            if (ModeFacturation::where('slug','=',$slug)->first()){
            $id = ModeFacturation::where('slug','=',$slug)->first()->id;
            showLog(ModeFacturation::class,$id);
            return response()->json(['content'=>new ModeFacturationResource(ModeFacturation::where('slug','=',$slug)->first()),'message'=>'détail ModeFacturation'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(ModeFacturation::class,$id);
          return response()->json(['message' => 'echec ,ModeFacturation n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (ModeFacturation::where('slug','=',$slug)->first()){
           $modefacturation = ModeFacturation::where('slug','=',$slug)->first();
           $data =  [
             'libelle'=>$request->libelle,
             'description'=>$request->description,
             'slug'=>str_slug(name_generator('mode-facturation',10),'-')
           ];
           if ($modefacturation->update($data)){
               $modefacturation =ModeFacturation::where('slug','=',$slug)->first();

               updateLog(ModeFacturation::class,$modefacturation->id);
               return response()->json(['message' => ' ModeFacturation mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(ModeFacturation::class,$modefacturation->id);
          return response()->json(['message' => ' echec mise à jours ModeFacturation  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(ModeFacturation::class,setZero());
      return response()->json(['message' => ' ModeFacturation n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (ModeFacturation::where('slug','=',$slug)->first()){
                    $modefacturation = ModeFacturation::where('slug','=',$slug)->first();
                    $modefacturation->delete();
                    deleteLog(ModeFacturation::class,$id);
                    return response()->json(['message' => ' ModeFacturation supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(ModeFacturation::class,setZero());
        return response()->json(['message' => ' ModeFacturation n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
