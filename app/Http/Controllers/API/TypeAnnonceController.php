<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\TypeAnnonce as TypeAnnonceResource;
use App\TypeAnnonce;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   TypeAnnonceController
|
|
|
|*/


class TypeAnnonceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!TypeAnnonceResource::collection(TypeAnnonce::paginate(10))->isEmpty()){
                   fetchLog(TypeAnnonce::class);
                    return response()->json(['content'=>TypeAnnonce::orderBy('created_at','desc')->paginate(10),'message'=>'liste des TypeAnnonces'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(TypeAnnonce::class);
                return response()->json(['message'=>'TypeAnnonces empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = [
         'libelle' =>$request->libelle,
         'slug' =>str_slug(name_generator('type-annoce',10),'-')
       ];
        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'libelle' => 'required|string|min:2',
        ];

        $messages = [
            'libelle.required' => 'Le champ libelle est obligatoire !',
            'libelle.string' => 'Le champ libelle doit contenir des chaines de charactères !',
            'libelle.min' => 'Le champ libelle doit contenir au moins deux charactères !'

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
       if (TypeAnnonce::create($data)) {
                 createLog(TypeAnnonce::class);
                  return response()->json(['message' => ' TypeAnnonce crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( TypeAnnonce::class);
       return response()->json(['message'=>'echec de création TypeAnnonce']);
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
            if (TypeAnnonce::where('slug','=',$slug)->first()){
            $id = TypeAnnonce::where('slug','=',$slug)->first()->id;
            showLog(TypeAnnonce::class,$id);
            return response()->json(['content'=>new TypeAnnonceResource(TypeAnnonce::where('slug','=',$slug)->first()),'message'=>'détail TypeAnnonce'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(TypeAnnonce::class,$id);
          return response()->json(['message' => 'echec ,TypeAnnonce n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (TypeAnnonce::where('slug','=',$slug)->first()){
           $typeannonce = TypeAnnonce::where('slug','=',$slug)->first();
           $data = [
             'libelle' =>$request->libelle,
             'slug' =>str_slug(name_generator('type-annoce',10),'-')
           ];
           if ($typeannonce->update($data)){
               $typeannonce =TypeAnnonce::where('slug','=',$slug)->first();

               updateLog(TypeAnnonce::class,$typeannonce->id);
               return response()->json(['message' => ' TypeAnnonce mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(TypeAnnonce::class,$typeannonce->id);
          return response()->json(['message' => ' echec mise à jours TypeAnnonce  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(TypeAnnonce::class,setZero());
      return response()->json(['message' => ' TypeAnnonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (TypeAnnonce::where('slug','=',$slug)->first()){
                    $typeannonce = TypeAnnonce::where('slug','=',$slug)->first();
                    $typeannonce->delete();
                    deleteLog(TypeAnnonce::class,$id);
                    return response()->json(['message' => ' TypeAnnonce supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(TypeAnnonce::class,setZero());
        return response()->json(['message' => ' TypeAnnonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
