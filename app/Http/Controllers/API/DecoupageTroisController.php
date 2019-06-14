<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\DecoupageTrois as DecoupageTroisResource;
use App\DecoupageTrois;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   DecoupageTroisController
|
|
|
|*/


class DecoupageTroisController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!DecoupageTroisResource::collection(DecoupageTrois::paginate(10))->isEmpty()){
                   fetchLog(DecoupageTrois::class);
                    return response()->json(['content'=>DecoupageTrois::orderBy('created_at','desc')->paginate(10),'message'=>'liste des DecoupageTroiss'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(DecoupageTrois::class);
                return response()->json(['message'=>'DecoupageTroiss empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data =  ['nom' =>$request->nom, 'libelle' =>$request->libelle,'decoupage_deux'=>$request->decoupage_deux,'slug'=>str_slug(name_generator('decoupage-trois',10),'-')];
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
       if (DecoupageTrois::create($data)) {
                 createLog(DecoupageTrois::class);
                  return response()->json(['message' => ' DecoupageTrois crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( DecoupageTrois::class);
       return response()->json(['message'=>'echec de création DecoupageTrois']);
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
            if (DecoupageTrois::where('slug','=',$slug)->first()){
            $id = DecoupageTrois::where('slug','=',$slug)->first()->id;
            showLog(DecoupageTrois::class,$id);
            return response()->json(['content'=>new DecoupageTroisResource(DecoupageTrois::where('slug','=',$slug)->first()),'message'=>'détail DecoupageTrois'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(DecoupageTrois::class,$id);
          return response()->json(['message' => 'echec ,DecoupageTrois n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (DecoupageTrois::where('slug','=',$slug)->first()){
           $decoupagetrois = DecoupageTrois::where('slug','=',$slug)->first();
           $data =  ['nom' =>$request->nom, 'libelle' =>$request->libelle,'decoupage_deux'=>$request->decoupage_deux,'slug'=>str_slug(name_generator('decoupage-trois',10),'-')];

           if ($decoupagetrois->update($data)){
               $decoupagetrois =DecoupageTrois::where('slug','=',$slug)->first();
               updateLog(DecoupageTrois::class,$decoupagetrois->id);
               return response()->json(['message' => ' DecoupageTrois mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(DecoupageTrois::class,$decoupagetrois->id);
          return response()->json(['message' => ' echec mise à jours DecoupageTrois  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(DecoupageTrois::class,setZero());
      return response()->json(['message' => ' DecoupageTrois n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (DecoupageTrois::where('slug','=',$slug)->first()){
                    $decoupagetrois = DecoupageTrois::where('slug','=',$slug)->first();
                    $decoupagetrois->delete();
                    deleteLog(DecoupageTrois::class,$id);
                    return response()->json(['message' => ' DecoupageTrois supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(DecoupageTrois::class,setZero());
        return response()->json(['message' => ' DecoupageTrois n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
