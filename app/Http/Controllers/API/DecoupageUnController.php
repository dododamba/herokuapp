<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\DecoupageUn as DecoupageUnResource;
use App\DecoupageUn;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   DecoupageUnController
|
|
|
|*/


class DecoupageUnController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!DecoupageUnResource::collection(DecoupageUn::paginate(10))->isEmpty()){
                   fetchLog(DecoupageUn::class);
                    return response()->json(['content'=>DecoupageUn::with('pays_relation_ship')->orderBy('created_at','desc')->paginate(10),'message'=>'liste des DecoupageUns'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(DecoupageUn::class);
                return response()->json(['message'=>'DecoupageUns empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
      $data =  ['nom' =>$request->nom, 'libelle' =>$request->libelle,'pays'=>$request->pays,'cheflieu'=>$request->cheflieu,'slug'=>str_slug(name_generator('decoupage-un',10),'-')];
        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'nom' => 'required|string|min:2',
        ];

        $messages = [
            'nom.required' => 'Le champ nom est obligatoire !',
            'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'nom.min' => 'Le champ nom doit contenir au moins deux charactères !'

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
       if (DecoupageUn::create($data)) {
                 createLog(DecoupageUn::class);
                  return response()->json(['message' => ' DecoupageUn crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( DecoupageUn::class);
       return response()->json(['message'=>'echec de création DecoupageUn']);
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
            if (DecoupageUn::where('slug','=',$slug)->first()){
            $id = DecoupageUn::where('slug','=',$slug)->first()->id;
            showLog(DecoupageUn::class,$id);
            return response()->json(['content'=>new DecoupageUnResource(DecoupageUn::where('slug','=',$slug)->first()),'message'=>'détail DecoupageUn'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(DecoupageUn::class,$id);
          return response()->json(['message' => 'echec ,DecoupageUn n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (DecoupageUn::where('slug','=',$slug)->first()){
           $decoupageun = DecoupageUn::where('slug','=',$slug)->first();
           $data =  ['nom' =>$request->nom, 'libelle' =>$request->libelle,'pays'=>$request->pays,'slug'=>str_slug(name_generator('decoupage-un',10),'-')];
           if ($decoupageun->update($data)){
               $decoupageun =DecoupageUn::where('slug','=',$slug)->first();
               updateLog(DecoupageUn::class,$decoupageun->id);
               return response()->json(['message' => ' DecoupageUn mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(DecoupageUn::class,$decoupageun->id);
          return response()->json(['message' => ' echec mise à jours DecoupageUn  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(DecoupageUn::class,setZero());
      return response()->json(['message' => ' DecoupageUn n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (DecoupageUn::where('slug','=',$slug)->first()){
                    $decoupageun = DecoupageUn::where('slug','=',$slug)->first();
                    $decoupageun->delete();
                    deleteLog(DecoupageUn::class,$id);
                    return response()->json(['message' => ' DecoupageUn supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(DecoupageUn::class,setZero());
        return response()->json(['message' => ' DecoupageUn n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
