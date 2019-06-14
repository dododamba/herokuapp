<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Share as ShareResource;
use App\Share;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ShareController
|
|
|
|*/


class ShareController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!ShareResource::collection(Share::paginate(10))->isEmpty()){
                  return response()->json(['content'=>Share::orderBy('created_at','desc')->paginate(10),200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'Shares empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
     if (Share::create($request->all())) {
                return response()->json(['message' => ' Share stored successful'],200,['Content-Type'=>'application/json']);

            }
     return response()->json(['message'=>'store Share failed !']);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   *
   * @return Response
   */
  public function show(Request $request,$slug)
   {
          if (Share::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new ShareResource(Share::where('slug','=',$slug)->first()),'message'=>'detail Share'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Share does not exist'],404,['Content-Type'=>'application/json']);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $slug
   *
   * @return Response
   */
  public function update(Request $request)
  {
        if (Share::where('slug','=',$slug)->first()){
         $share = Share:::where('slug','=',$slug)->first();
         if ($share->update($request->all())){
             $share =Share::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Share updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Share does not exist !'],404,['Content-Type'=>'application/json']);
   }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $slug
   *
   * @return Response
   */
  public function destroy(Request $request,$slug)
   {
            if (Share::where('slug','=',$slug)->first()){
                  $share = Share::where('slug','=',$slug)->first();
                  $share->delete();
                  return response()->json(['message' => ' Share deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Share does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}