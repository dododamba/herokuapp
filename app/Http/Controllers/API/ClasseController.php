<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Classe as ClasseResource;
use App\Classe;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ClasseController
|
|
|
|*/


class ClasseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!ClasseResource::collection(Classe::all())->isEmpty()){
                   fetchLog(Classe::class);
                    return response()->json(['content'=>Classe::all(),'message'=>'liste des Classes'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Classe::class);
                return response()->json(['message'=>'Classes empty']);

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
         'slug' =>str_slug(name_generator('classe',10),'-'),
         'description'  =>$request->description
       ];

        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'libelle' => 'required|string|min:2|max:100',

        ];

        $messages = [
            'libelle.required' => 'Le champ libelle est obligatoire !',
            'libelle.string' => 'Le champ libelle doit contenir des chaines de charactères !',
            'libelle.min' => 'Le champ libelle doit contenir au moins deux charactères !',
            'libelle.max' => 'Le champ libelle ne doit pas exceder 100 charactères !',

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

       if (Classe::create($data)) {
                 createLog(Classe::class);
                  return response()->json(['message' => ' Classe crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( Classe::class);
       return response()->json(['message'=>'echec de création Classe']);
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
            if (Classe::where('slug','=',$slug)->first()){
            $id = Classe::where('slug','=',$slug)->first()->id;
            showLog(Classe::class,$id);
            return response()->json(['content'=>new ClasseResource(Classe::where('slug','=',$slug)->first()),'message'=>'détail Classe'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Classe::class,$id);
          return response()->json(['message' => 'echec ,Classe n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (Classe::where('slug','=',$slug)->first()){
           $classe = Classe::where('slug','=',$slug)->first();

           $data = [
             'libelle' =>$request->libelle,
             'slug' =>str_slug(name_generator('classe',10),'-'),
             'description'  =>$request->description
           ];

           if ($classe->update($data)){
               $classe =Classe::where('slug','=',$slug)->first();
               updateLog(Classe::class,$classe->id);
               return response()->json(['message' => ' Classe mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Classe::class,$classe->id);
          return response()->json(['message' => ' echec mise à jours Classe  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Classe::class,setZero());
      return response()->json(['message' => ' Classe n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Classe::where('slug','=',$slug)->first()){
                    $classe = Classe::where('slug','=',$slug)->first();
                    $classe->delete();
                    deleteLog(Classe::class,$id);
                    return response()->json(['message' => ' Classe supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Classe::class,setZero());
        return response()->json(['message' => ' Classe n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
