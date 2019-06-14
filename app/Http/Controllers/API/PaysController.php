<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Pays as PaysResource;
use App\Pays;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   PaysController
|
|
|
|*/


class PaysController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pays = Pays::orderBy('nom','asc')->paginate(10);

        if (!PaysResource::collection($pays)->isEmpty()) {
             fetchLog(Pays::class);
            return response()->json(
                [
                    'content' => [
                        'pays'=>$pays ,
                        'message' => 'liste des pays'
                    ]
                ], 200, ['Content-Type' => 'application/json']);

        }
          fetchEmptyLog(Pays::class);
        return response()->json(['message' => 'Pays empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = ['nom'=>$request->nom,'capitale'=>$request->capitale,'slug' =>str_slug(name_generator('pays',10),'-')];

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

        if (Pays::create($data)) {
            createLog(Pays::class);
            return response()->json(['message' => ' Pays crée avec succès'],200,['Content-Type'=>'application/json']);

        }
        createFailureLog( Pays::class);
        return response()->json(['message'=>'echec de création Pays']);
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
        if (Pays::where('slug','=',$slug)->first()){
            $pay = Pays::where('slug','=',$slug)->first();
            $data = [
                'nom'=>$request->nom,
                'capitale' =>$request->capitale,
                'slug' =>str_slug(name_generator('pays',10),'-')];

            if ($pay->update($data)){
                $pay =Pays::where('slug','=',$slug)->first();
                //updateLog(Pays::class,$pay->id);
                return response()->json(['message' => ' Pays mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                updateFailureLog(Pays::class,$pay->id);
                return response()->json(['message' => ' echec mise à jours Pays  !'],400,['Content-Type'=>'application/json']);
            }

        }

        notFoundLog(Pays::class,setZero());
        return response()->json(['message' => ' Pays n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
        if (Pays::where('slug','=',$slug)->first()){
            $pay = Pays::where('slug','=',$slug)->first();
            $pay->delete();
            deleteLog(Pays::class);
            return response()->json(['message' => ' Pays supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        deleteFailureLog(Pays::class,setZero());
        return response()->json(['message' => ' Pays n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
