<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\DecoupageDeux as DecoupageDeuxResource;
use App\DecoupageDeux;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   DecoupageDeuxController
|
|
|
|*/


class DecoupageDeuxController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!DecoupageDeuxResource::collection(DecoupageDeux::paginate(10))->isEmpty()){
                   fetchLog(DecoupageDeux::class);
                    return response()->json(['content'=>DecoupageDeux::orderBy('created_at','desc')->paginate(10),'message'=>'liste des DecoupageDeuxs'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(DecoupageDeux::class);
                return response()->json(['message'=>'DecoupageDeuxs empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = ['nom' =>$request->nom, 'libelle'=>$request->libelle, 'decoupage_un'=>$request->decoupage_un,'slug'=>str_slug(name_generator('decoupage-deux',10),'-')];

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


       if (DecoupageDeux::create($data)) {
                 createLog(DecoupageDeux::class);
                  return response()->json(['message' => ' DecoupageDeux crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( DecoupageDeux::class);
       return response()->json(['message'=>'echec de création DecoupageDeux']);
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
            if (DecoupageDeux::where('slug','=',$slug)->first()){
            $id = DecoupageDeux::where('slug','=',$slug)->first()->id;
            showLog(DecoupageDeux::class,$id);
            return response()->json(['content'=>new DecoupageDeuxResource(DecoupageDeux::where('slug','=',$slug)->first()),'message'=>'détail DecoupageDeux'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(DecoupageDeux::class,$id);
          return response()->json(['message' => 'echec ,DecoupageDeux n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (DecoupageDeux::where('slug','=',$slug)->first()){
           $decoupagedeux = DecoupageDeux::where('slug','=',$slug)->first();
           $data = ['nom' =>$request->nom, 'libelle'=>$request->libelle, 'decoupage_un'=>$request->decoupage_un,'slug'=>str_slug(name_generator('decoupage-deux',10),'-')];

           if ($decoupagedeux->update($data)){
               $decoupagedeux =DecoupageDeux::where('slug','=',$slug)->first();
               $data = ['nom' =>$request->nom, 'libelle'=>$request->libelle, 'decoupage_un'=>$request->decoupage_un,'slug'=>str_slug($request->nom,'-')];

               updateLog(DecoupageDeux::class,$decoupagedeux->id);
               return response()->json(['message' => ' DecoupageDeux mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(DecoupageDeux::class,$decoupagedeux->id);
          return response()->json(['message' => ' echec mise à jours DecoupageDeux  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(DecoupageDeux::class,setZero());
      return response()->json(['message' => ' DecoupageDeux n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (DecoupageDeux::where('slug','=',$slug)->first()){
                    $decoupagedeux = DecoupageDeux::where('slug','=',$slug)->first();
                    $decoupagedeux->delete();
                    deleteLog(DecoupageDeux::class,$id);
                    return response()->json(['message' => ' DecoupageDeux supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(DecoupageDeux::class,setZero());
        return response()->json(['message' => ' DecoupageDeux n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
