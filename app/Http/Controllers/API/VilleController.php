<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Ville as VilleResource;
use App\Ville;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   VilleController
|
|
|
|*/


class VilleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if(!VilleResource::collection(Ville::paginate(10))->isEmpty()){
            fetchLog(Ville::class);
            return response()->json(['content'=>Ville::with('pays_relation_ship')->orderBy('created_at','desc')->paginate(10),'message'=>'liste des Villes'],200,['Content-Type'=>'application/json']);

        }
        fetchEmptyLog(Ville::class);
        return response()->json(['message'=>'Villes empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data =  [
            'nom' =>$request->nom,
            'pays' =>$request->pays,
            'decoupage_un' =>$request->decoupage_un,
            'slug'=>str_slug(name_generator('ville',10),'-')
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

        if (Ville::create($data)) {
            createLog(Ville::class);
            return response()->json(['message' => ' Ville crée avec succès'],200,['Content-Type'=>'application/json']);

        }
        createFailureLog( Ville::class);
        return response()->json(['message'=>'echec de création Ville']);
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
        if (Ville::where('slug','=',$slug)->first()){
            $id = Ville::where('slug','=',$slug)->first()->id;
            showLog(Ville::class,$id);
            return response()->json(['content'=>new VilleResource(Ville::where('slug','=',$slug)->first()),'message'=>'détail Ville'],200,['Content-Type'=>'application/json']);
        }

        // notFoundLog(Ville::class);
        return response()->json(['message' => 'echec ,Ville n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    public function pays_ville($id_pays) {

        if(!Ville::where('pays', $id_pays)->get()->isEmpty()){

            fetchLog(Ville::class);
            return response()->json(
                ['content'=>Ville::where('pays', $id_pays)->get()
                    ,'message'=>'liste des Villes'],
                200, ['Content-Type'=>'application/json']);

        }
        fetchEmptyLog(Ville::class);
        return response()->json(['message' => ' Pas de ville pour ce pays !'],404,['Content-Type'=>'application/json']);

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
        if (Ville::where('slug','=',$slug)->first()){
            $ville = Ville::where('slug','=',$slug)->first();
            $data =  [
                'nom' =>$request->nom,
                'pays' =>$request->pays,
                'decoupage_un' =>$request->decoupage_un,
                'slug'=>str_slug(name_generator('ville',10),'-')
            ];

            if ($ville->update($data)){
                $ville =Ville::where('slug','=',$slug)->first();
                updateLog(Ville::class,$ville->id);
                return response()->json(['message' => ' Ville mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                updateFailureLog(Ville::class,$ville->id);
                return response()->json(['message' => ' echec mise à jours Ville  !'],400,['Content-Type'=>'application/json']);
            }

        }

        notFoundLog(Ville::class,setZero());
        return response()->json(['message' => ' Ville n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
        if (Ville::where('slug','=',$slug)->first()){
            $ville = Ville::where('slug','=',$slug)->first();
            $ville->delete();
            deleteLog(Ville::class,$id);
            return response()->json(['message' => ' Ville supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        deleteFailureLog(Ville::class,setZero());
        return response()->json(['message' => ' Ville n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
