<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Transaction as TransactionResource;
use App\Transaction;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   TransactionController
|
|
|
|*/


class TransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!TransactionResource::collection(Transaction::paginate(10))->isEmpty()){
                   fetchLog(Transaction::class);
                    return response()->json(['content'=>Transaction::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Transactions'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Transaction::class);
                return response()->json(['message'=>'Transactions empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = [
         'montant'=>$request->montant,
         'date_paiement'=>$request->date_paiement,
         'numero_debiteur'=>$request->numero_debiteur,
         'numero_beneficiaire'=>$request->numero_beneficiaire,
         'client'=>$request->client,
         'resevation_voyage'=>$request->resevation_voyage,
         'reservation_location'=>$request->reservation_location,
         'slug'=>str_slug(name_generator('transaction',10),'-')
       ];

       if (Transaction::create($data)) {
                 createLog(Transaction::class);
                  return response()->json(['message' => ' Transaction crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( Transaction::class);
       return response()->json(['message'=>'echec de création Transaction']);
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
            if (Transaction::where('slug','=',$slug)->first()){
            $id = Transaction::where('slug','=',$slug)->first()->id;
            showLog(Transaction::class,$id);
            return response()->json(['content'=>new TransactionResource(Transaction::where('slug','=',$slug)->first()),'message'=>'détail Transaction'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Transaction::class,$id);
          return response()->json(['message' => 'echec ,Transaction n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (Transaction::where('slug','=',$slug)->first()){
           $transaction = Transaction::where('slug','=',$slug)->first();
           $data = [
             'montant'=>$request->montant,
             'date_paiement'=>$request->date_paiement,
             'numero_debiteur'=>$request->numero_debiteur,
             'numero_beneficiaire'=>$request->numero_beneficiaire,
             'client'=>$request->client,
             'resevation_voyage'=>$request->resevation_voyage,
             'reservation_location'=>$request->reservation_location,
             'slug'=>str_slug(name_generator('transaction',10),'-')
           ];
           if ($transaction->update($data)){
               $transaction =Transaction::where('slug','=',$slug)->first();
               updateLog(Transaction::class,$transaction->id);
               return response()->json(['message' => ' Transaction mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Transaction::class,$transaction->id);
          return response()->json(['message' => ' echec mise à jours Transaction  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Transaction::class,setZero());
      return response()->json(['message' => ' Transaction n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Transaction::where('slug','=',$slug)->first()){
                    $transaction = Transaction::where('slug','=',$slug)->first();
                    $transaction->delete();
                    deleteLog(Transaction::class,$id);
                    return response()->json(['message' => ' Transaction supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Transaction::class,setZero());
        return response()->json(['message' => ' Transaction n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
