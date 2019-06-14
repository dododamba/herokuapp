<?php

namespace App\Http\Controllers\API;
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
                   fetchLog(Note::class);
                    return response()->json(
                        ['content'=>Note::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Notes'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Note::class);
                return response()->json(['message'=>'Notes empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

      $data = [
        'appreciation' =>$request->appreciation,
        'message'=>$request->message,
        'utilisateur'=>$request->utilisateur,
        'voyage'=>$request->voyage,
        'slug'=>str_slug(name_generator('note',10),'-')
      ];

       if (Note::create($data)) {
                 createLog(Note::class);
                  return response()->json(['message' => ' Note crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog(Note::class);
       return response()->json(['message'=>'echec de création Note']);
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
          if (Note::where('slug','=',$slug)->first()){
           $note = Note::where('slug','=',$slug)->first();
           $data = [
             'appreciation' =>$request->appreciation,
             'message'=>$request->message,
             'utilisateur'=>$request->utilisateur,
             'voyage'=>$request->voyage,
             'slug'=>str_slug(name_generator('note',10),'-')
           ];

           if ($note->update($data)){
               $note =Note::where('slug','=',$slug)->first();

               updateLog(Note::class,$note->id);
               return response()->json(['message' => ' Note mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Note::class,$note->id);
          return response()->json(['message' => ' echec mise à jours Note  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Note::class,setZero());
      return response()->json(['message' => ' Note n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Note::where('slug','=',$slug)->first()){
                    $note = Note::where('slug','=',$slug)->first();
                    $note->delete();
                    deleteLog(Note::class);
                    return response()->json(['message' => ' Note supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Note::class,setZero());
        return response()->json(['message' => ' Note n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
