<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\ReservationVoyage as ReservationVoyageResource;
use App\ReservationVoyage;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ReservationVoyageController
|
|
|
|*/


class ReservationVoyageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!ReservationVoyageResource::collection(ReservationVoyage::paginate(10))->isEmpty()){
                   fetchLog(ReservationVoyage::class);
                    return response()->json(['content'=>ReservationVoyage::orderBy('created_at','desc')->paginate(10),'message'=>'liste des ReservationVoyages'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(ReservationVoyage::class);
                return response()->json(['message'=>'ReservationVoyages empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = [
         'date_reservation' =>$request->date_reservation,
         'date_validation' =>$request->date_validation,
         'dateVoyage' =>$request->dateVoyage,
         'statut' =>$request->statut,
         'nom_voyageur' =>$request->nom_voyageur,
         'client' =>$request->client,
         'slug' =>str_slug(name_generator('reservation',10),'-')
       ];


       if (ReservationVoyage::create($data)) {
                 createLog(ReservationVoyage::class);
                  return response()->json(['message' => ' ReservationVoyage crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( ReservationVoyage::class);
       return response()->json(['message'=>'echec de création ReservationVoyage']);
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
            if (ReservationVoyage::where('slug','=',$slug)->first()){
            $id = ReservationVoyage::where('slug','=',$slug)->first()->id;
            showLog(ReservationVoyage::class,$id);
            return response()->json(['content'=>new ReservationVoyageResource(ReservationVoyage::where('slug','=',$slug)->first()),'message'=>'détail ReservationVoyage'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(ReservationVoyage::class,$id);
          return response()->json(['message' => 'echec ,ReservationVoyage n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (ReservationVoyage::where('slug','=',$slug)->first()){
           $reservationvoyage = ReservationVoyage::where('slug','=',$slug)->first();
           $data = [
             'date_reservation' =>$request->date_reservation,
             'date_validation' =>$request->date_validation,
             'dateVoyage' =>$request->dateVoyage,
             'statut' =>$request->statut,
             'nom_voyageur' =>$request->nom_voyageur,
             'client' =>$request->client,
             'slug' =>str_slug(name_generator('reservation',10),'-')
           ];
           if ($reservationvoyage->update($data)){
               $reservationvoyage =ReservationVoyage::where('slug','=',$slug)->first();
               updateLog(ReservationVoyage::class,$reservationvoyage->id);
               return response()->json(['message' => ' ReservationVoyage mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(ReservationVoyage::class,$reservationvoyage->id);
          return response()->json(['message' => ' echec mise à jours ReservationVoyage  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(ReservationVoyage::class,setZero());
      return response()->json(['message' => ' ReservationVoyage n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (ReservationVoyage::where('slug','=',$slug)->first()){
                    $reservationvoyage = ReservationVoyage::where('slug','=',$slug)->first();
                    $reservationvoyage->delete();
                    deleteLog(ReservationVoyage::class,$id);
                    return response()->json(['message' => ' ReservationVoyage supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(ReservationVoyage::class,setZero());
        return response()->json(['message' => ' ReservationVoyage n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
