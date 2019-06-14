<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\CategorieArticle as CategorieArticleResource;
use App\CategorieArticle;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   CategorieArticleController
|
|
|
|*/


class CategorieArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!CategorieArticleResource::collection(CategorieArticle::paginate(10))->isEmpty()){
                   fetchLog(CategorieArticle::class);
                    return response()->json(['content'=>CategorieArticle::orderBy('created_at','desc')->paginate(10),'message'=>'liste des CategorieArticles'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(CategorieArticle::class);
                return response()->json(['message'=>'CategorieArticles empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
      $data = [
        'nom' =>$request->nom,
        'description' =>$request->description,
        'slug' =>str_slug(name_generator('categorie-article',10),'-'),
        'ajoute_par' =>$request->ajoute_par
      ];

        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'nom' => 'required|string|min:2|max:100',

        ];

        $messages = [
            'nom.required' => 'Le champ nom est obligatoire !',
            'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',

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


       if (CategorieArticle::create($data)) {
                 createLog(CategorieArticle::class);
                  return response()->json(['message' => ' CategorieArticle crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( CategorieArticle::class);
       return response()->json(['message'=>'echec de création CategorieArticle']);
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
            if (CategorieArticle::where('slug','=',$slug)->first()){
            $id = CategorieArticle::where('slug','=',$slug)->first()->id;
            showLog(CategorieArticle::class,$id);
            return response()->json(['content'=>new CategorieArticleResource(CategorieArticle::where('slug','=',$slug)->first()),'message'=>'détail CategorieArticle'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(CategorieArticle::class,setZero());
          return response()->json(['message' => 'echec ,CategorieArticle n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (CategorieArticle::where('slug','=',$slug)->first()){
           $categoriearticle = CategorieArticle::where('slug','=',$slug)->first();
           $data = [
             'nom' =>$request->nom,
             'description' =>$request->description,
             'slug' =>str_slug(name_generator('categorie-article',10),'-'),
             'ajoute_par' =>$request->ajoute_par
           ];
           if ($categoriearticle->update($data)){
               $categoriearticle =CategorieArticle::where('slug','=',$slug)->first();
               updateLog(CategorieArticle::class,$categoriearticle->id);
               return response()->json(['message' => ' CategorieArticle mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(CategorieArticle::class,$categoriearticle->id);
          return response()->json(['message' => ' echec mise à jours CategorieArticle  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(CategorieArticle::class,setZero());
      return response()->json(['message' => ' CategorieArticle n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (CategorieArticle::where('slug','=',$slug)->first()){
                    $categoriearticle = CategorieArticle::where('slug','=',$slug)->first();
                    $categoriearticle->delete();
                    deleteLog(CategorieArticle::class,$categoriearticle->id);
                    return response()->json(['message' => ' CategorieArticle supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(CategorieArticle::class,setZero());
        return response()->json(['message' => ' CategorieArticle n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
