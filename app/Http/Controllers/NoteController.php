<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Note as NoteResource;
use App\Note;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   NoteController
|
|
|
|*/


class NoteController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!NoteResource::collection(Note::paginate(10))->isEmpty()){
                  return response()->json(['content'=>Note::orderBy('created_at','desc')->paginate(10),200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'Notes empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
     if (Note::create($request->all())) {
                return response()->json(['message' => ' Note stored successful'],200,['Content-Type'=>'application/json']);

            }
     return response()->json(['message'=>'store Note failed !']);
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
          if (Note::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new NoteResource(Note::where('slug','=',$slug)->first()),'message'=>'detail Note'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Note does not exist'],404,['Content-Type'=>'application/json']);
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
        if (Note::where('slug','=',$slug)->first()){
         $note = Note:::where('slug','=',$slug)->first();
         if ($note->update($request->all())){
             $note =Note::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Note updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Note does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (Note::where('slug','=',$slug)->first()){
                  $note = Note::where('slug','=',$slug)->first();
                  $note->delete();
                  return response()->json(['message' => ' Note deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Note does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}