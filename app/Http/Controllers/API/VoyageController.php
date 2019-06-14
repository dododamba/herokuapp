<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Voyage as VoyageResource;
use App\Voyage;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   VoyageController
|
|
|
|*/


class VoyageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if(!VoyageResource::collection(Voyage::paginate(10))->isEmpty()){
            fetchLog(Voyage::class);
            return response()->json(['content'=>Voyage::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Voyages'],200,['Content-Type'=>'application/json']);

        }
        fetchEmptyLog(Voyage::class);
        return response()->json(['message'=>'Voyages empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {



        $new_itineraire = [
          'ville_depart' => $request->ville_depart,
          'ville_arrive' => $request->ville_arrive,
          'description' => '',
          'slug' => str_slug(name_generator('itineraire', 10), '-'),
        ];


        // Calculer etat en fonction du type d'utilisateur qui crée le voyage

        $new_voyage = [
            'numero' =>$request->num_voyage,
            'date_depart' =>$request->date_depart." ".$request->heure_depart,
            'description' =>$request->description,
            'duree' =>$request->duree_voyage,
            'nombre_place' =>$request->nombre_place,
            'moyen_transport' =>$request->moyen_transport,
            'slug' =>str_slug(name_generator('voyage',10),'-'),

        ];



        if (Voyage::create($new_voyage)) {
            createLog(Voyage::class);
            return response()->json(['message' => ' Voyage crée avec succès'],200,['Content-Type'=>'application/json']);

        }
        createFailureLog( Voyage::class);
        return response()->json(['message'=>'echec de création Voyage']);
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
        if (Voyage::where('slug','=',$slug)->first()){
            $id = Voyage::where('slug','=',$slug)->first()->id;
            showLog(Voyage::class,$id);
            return response()->json(['content'=>new VoyageResource(Voyage::where('slug','=',$slug)->first()),'message'=>'détail Voyage'],200,['Content-Type'=>'application/json']);
        }

        notFoundLog(Voyage::class,$id);
        return response()->json(['message' => 'echec ,Voyage n\existe pas'],404,['Content-Type'=>'application/json']);
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
        if (Voyage::where('slug','=',$slug)->first()){
            $voyage = Voyage::where('slug','=',$slug)->first();
            $data = [
                'numero' =>$request->numero,
                'date_depart' =>$request->date_depart,
                'date_arrive' =>$request->date_arrive,
                'description' =>$request->description,
                'nombre_place' =>$request->nombre_place,
                'moyen_transport' =>$request->moyen_transport,
                'etat' =>$request->etat,
                'itineraire' =>$request->itineraire,
                'image' =>$request->image,
                'utilisateur' =>$request->utilisateur,
                'partenire' =>$request->partenire,
                'personnel' =>$request->personnel,
                'slug' =>str_slug(name_generator('voyage',10),'-')
            ];


            if ($voyage->update($data)){
                $voyage =Voyage::where('slug','=',$slug)->first();
                updateLog(Voyage::class,$voyage->id);
                return response()->json(['message' => ' Voyage mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
            }else{
                updateFailureLog(Voyage::class,$voyage->id);
                return response()->json(['message' => ' echec mise à jours Voyage  !'],400,['Content-Type'=>'application/json']);
            }

        }

        notFoundLog(Voyage::class,setZero());
        return response()->json(['message' => ' Voyage n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
        if (Voyage::where('slug','=',$slug)->first()){
            $voyage = Voyage::where('slug','=',$slug)->first();
            $voyage->delete();
            deleteLog(Voyage::class,$id);
            return response()->json(['message' => ' Voyage supprimé avec succès'],200,['Content-Type'=>'application/json']);
        }

        deleteFailureLog(Voyage::class,setZero());
        return response()->json(['message' => ' Voyage n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
