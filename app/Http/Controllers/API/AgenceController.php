<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\Agence as AgenceResource;
use App\Agence;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   AgenceController
|
|
|
|*/


class AgenceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if(!AgenceResource::collection(Agence::paginate(10))->isEmpty()){
            fetchLog(Agence::class);
            return response()->json(['content'=>Agence::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Agences'],200,['Content-Type'=>'application/json']);

        }
        fetchEmptyLog(Agence::class);
        return response()->json(['message'=>'Agences empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $assert_false = 0;
        $assert_true = 1;

        $data = [
            'nom' => $request->nom,
            'slug' =>str_randomize(10),
        ];

        $rules = [
            'nom' => 'required|string|min:2|max:100',

        ];

        $messages = [
            'nom.required' => 'Le champ nom est obligatoire !',
            'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',

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

        $data = [
            'libelle' =>$request->libelle,
            'longitude' =>$request->longitude,
            'latitude' =>$request->latitude,
            'contact' =>$request->contact,
            'slug' => str_slug(name_generator('agence',10),'-'),
            'adresse' =>$request->adresse,
            'email' =>$request->email,
            'ville' =>$request->ville,
            'utilisateur' =>$request->utilisateur,
            'partenaire' =>$request->partenaire
        ];


        if (Agence::create($request->all($data))) {
            createLog(Agence::class);
            return response()->json(['message' => ' Agence crée avec succès'],200,['Content-Type'=>'application/json']);

        }
        createFailureLog(Agence::class);
        return response()->json(['message'=>'echec de création Agence']);
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
        if (Agence::where('slug','=',$slug)->first()){
            $id = Agence::where('slug','=',$slug)->first()->id;
            showLog(Agence::class,$id);
            return response()->json(['content'=>new AgenceResource(Agence::where('slug','=',$slug)->first()),'message'=>'détail Agence'],200,['Content-Type'=>'application/json']);
        }

        notFoundLog(Agence::class,setZero());
        return response()->json(['message' => 'echec ,Agence n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  string $slug
     *
     * @return Response
     */
    public function update(Request $request, $slug)
    {
        if (Agence::where('slug','=',$slug)->first()){
            $agence = Agence::where('slug','=',$slug)->first();

            $data = [
                'libelle' =>$request->libelle,
                'longitude' =>$request->longitude,
                'latitude' =>$request->latitude,
                'contact' =>$request->contact,
                'slug' => str_slug(name_generator('agence',10),'-'),
                'adresse' =>$request->adresse,
                'email' =>$request->email,
                'ville' =>$request->ville,
                'utilisateur' =>$request->utilisateur,
                'partenaire' =>$request->partenaire
            ];


            if ($agence->update($request->all($data))){
                $agence =Agence::where('slug','=',$slug)->first();
                updateLog(Agence::class,$agence->id);
                return response()->json(['message' => ' Agence mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                updateFailureLog(Agence::class,$agence->id);
                return response()->json(['message' => ' echec mise à jours Agence  !'],400,['Content-Type'=>'application/json']);
            }

        }

        notFoundLog(Agence::class,setZero());
        return response()->json(['message' => ' Agence n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
        if (Agence::where('slug','=',$slug)->first()){
            $agence = Agence::where('slug','=',$slug)->first();
            $agence->delete();
            deleteLog(Agence::class,$id);
            return response()->json(['message' => ' Agence supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        deleteFailureLog(Agence::class,setZero());
        return response()->json(['message' => ' Agence n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
