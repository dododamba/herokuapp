<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\ReservationLocation as ReservationLocationResource;
use App\ReservationLocation;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ReservationLocationController
|
|
|
|*/


class ReservationLocationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!ReservationLocationResource::collection(ReservationLocation::paginate(10))->isEmpty()){
                   fetchLog(ReservationLocation::class);
                    return response()->json(['content'=>ReservationLocation::orderBy('created_at','desc')->paginate(10),'message'=>'liste des ReservationLocations'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(ReservationLocation::class);
                return response()->json(['message'=>'ReservationLocations empty']);

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
         'statut' =>$request->statut,
         'date_debut' =>$request->date_debut,
         'date_fin' =>$request->date_fin,
         'location' =>$request->location,
         'commentaire' =>$request->commentaire,
         'note' =>$request->note,
         'client' =>$request->client,
         'slug' => str_slug(name_generator('reservation-location',10),'-')
       ];

       if (ReservationLocation::create($data)) {
                 createLog(ReservationLocation::class);
                  return response()->json(['message' => ' ReservationLocation crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( ReservationLocation::class);
       return response()->json(['message'=>'echec de création ReservationLocation']);
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
            if (ReservationLocation::where('slug','=',$slug)->first()){
            $id = ReservationLocation::where('slug','=',$slug)->first()->id;
            showLog(ReservationLocation::class,$id);
            return response()->json(['content'=>new ReservationLocationResource(ReservationLocation::where('slug','=',$slug)->first()),'message'=>'détail ReservationLocation'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(ReservationLocation::class,$id);
          return response()->json(['message' => 'echec ,ReservationLocation n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (ReservationLocation::where('slug','=',$slug)->first()){
           $reservationlocation = ReservationLocation::where('slug','=',$slug)->first();
           $data = [
             'date_reservation' =>$request->date_reservation,
             'date_validation' =>$request->date_validation,
             'statut' =>$request->statut,
             'date_debut' =>$request->date_debut,
             'date_fin' =>$request->date_fin,
             'location' =>$request->location,
             'commentaire' =>$request->commentaire,
             'note' =>$request->note,
             'client' =>$request->client,
             'slug' => str_slug(name_generator('reservation-location',10),'-')
           ];
           if ($reservationlocation->update($data)){
               $reservationlocation =ReservationLocation::where('slug','=',$slug)->first();
               updateLog(ReservationLocation::class,$reservationlocation->id);
               return response()->json(['message' => ' ReservationLocation mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(ReservationLocation::class,$reservationlocation->id);
          return response()->json(['message' => ' echec mise à jours ReservationLocation  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(ReservationLocation::class,setZero());
      return response()->json(['message' => ' ReservationLocation n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (ReservationLocation::where('slug','=',$slug)->first()){
                    $reservationlocation = ReservationLocation::where('slug','=',$slug)->first();
                    $reservationlocation->delete();
                    deleteLog(ReservationLocation::class,$id);
                    return response()->json(['message' => ' ReservationLocation supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(ReservationLocation::class,setZero());
        return response()->json(['message' => ' ReservationLocation n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
