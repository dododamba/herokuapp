<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Notification as NotificationResource;
use App\Notification;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   NotificationController
|
|
|
|*/


class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!NotificationResource::collection(Notification::paginate(10))->isEmpty()){
                   fetchLog(Notification::class);
                    return response()->json(['content'=>Notification::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Notifications'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Notification::class);
                return response()->json(['message'=>'Notifications empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = [
         'contenue'=>$request->contenue,
         'date'=>$request->date,
          'description'=>$request->description,
          'lien'=>$request->lien,
           'adresse_email'=>$request->adresse_email,
           'numero_destination'=>$request->numero_destination,
           'type'=>$request->type,
           'slug'=>str_slug(name_generator('notification',10),'-')
         ];

       if (Notification::create($data)) {
                 createLog(Notification::class);
                  return response()->json(['message' => ' Notification crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( Notification::class);
       return response()->json(['message'=>'echec de création Notification']);
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
            if (Notification::where('slug','=',$slug)->first()){
            $id = Notification::where('slug','=',$slug)->first()->id;
            showLog(Notification::class,$id);
            return response()->json(['content'=>new NotificationResource(Notification::where('slug','=',$slug)->first()),'message'=>'détail Notification'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Notification::class,$id);
          return response()->json(['message' => 'echec ,Notification n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (Notification::where('slug','=',$slug)->first()){
           $notification = Notification::where('slug','=',$slug)->first();
           $data = [
             'contenue'=>$request->contenue,
             'date'=>$request->date,
              'description'=>$request->description,
              'lien'=>$request->lien,
               'adresse_email'=>$request->adresse_email,
               'numero_destination'=>$request->numero_destination,
               'type'=>$request->type,
               'slug'=>str_slug(name_generator('notification',10),'-')
             ];

           if ($notification->update($data)){
               $notification =Notification::where('slug','=',$slug)->first();
               updateLog(Notification::class,$notification->id);
               return response()->json(['message' => ' Notification mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Notification::class,$notification->id);
          return response()->json(['message' => ' echec mise à jours Notification  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Notification::class,setZero());
      return response()->json(['message' => ' Notification n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Notification::where('slug','=',$slug)->first()){
                    $notification = Notification::where('slug','=',$slug)->first();
                    $notification->delete();
                    deleteLog(Notification::class,$id);
                    return response()->json(['message' => ' Notification supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Notification::class,setZero());
        return response()->json(['message' => ' Notification n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
