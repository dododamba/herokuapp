<?php

namespace App\Http\Controllers\API;
use App\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ArticleController
|
|
|
|*/


class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!ArticleResource::collection(Article::paginate(10))->isEmpty()){
                   fetchLog(Article::class);
                    return response()->json(['content'=>ArticleResource::collection(Article::orderBy('created_at','desc')->paginate(10)),'message'=>'liste des Articles'],200,['Content-Type'=>'application/json']);
                }
                fetchEmptyLog(Article::class);
                return response()->json(['message'=>'Articles empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = [
          'titre' =>$request->titre,
          'contenu' =>$request->contenu,
          'slug' => str_slug(name_generator('article',10),'-'),
          'categorie' =>$request->categorie,
          'etat' =>$request->etat,
          'utilisateur' =>$request->utilisateur,
          'personnel' =>$request->personnel
       ];

        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'titre' => 'required|string|min:2|max:100',

        ];

        $messages = [
            'titre.required' => 'Le champ titre est obligatoire !',
            'titre.string' => 'Le champ titre doit contenir des chaines de charactères !',
            'titre.min' => 'Le champ titre doit contenir au moins deux charactères !',
            'titre.max' => 'Le champ titre ne doit pas exceder 100 charactères !',

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

        if (Article::create($data)) {
                 createLog(Article::class);
                  return response()->json(['message' => ' Article crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( Article::class);
       return response()->json(['message'=>'echec de création Article']);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function show(Request $request,$slug)
     {
            if (Article::where('slug','=',$slug)->first()){
            $id = Article::where('slug','=',$slug)->first()->id;
            showLog(Article::class,$id);
            return response()->json(['content'=>new ArticleResource(Article::where('slug','=',$slug)->first()),'message'=>'détail Article'],200,['Content-Type'=>'application/json']);
            }

           notFoundLog(Article::class, setZero());
          return response()->json(['message' => 'echec ,Article n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function update(Request $request,$slug)
    {
          if (Article::where('slug','=',$slug)->first()){
           $article = Article::where('slug','=',$slug)->first();
           $data = [
              'titre' =>$request->titre,
              'contenu' =>$request->contenu,
              'slug' => str_slug(name_generator('article',10),'-'),
              'categorie' =>$request->categorie,
              'etat' =>$request->etat,
              'utilisateur' =>$request->utilisateur,
              'personnel' =>$request->personnel
           ];
              if ($article->update($data)) {
               $article =Article::where('slug','=',$slug)->first();
               updateLog(Article::class,$article->id);
               return response()->json(['message' => ' Article mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
              }
          updateFailureLog(Article::class,$article->id);
          return response()->json(['message' => ' echec mise à jours Article  !'],400,['Content-Type'=>'application/json']);

       }

      notFoundLog(Article::class,setZero());
      return response()->json(['message' => ' Article n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Article::where('slug','=',$slug)->first()){
                    $article = Article::where('slug','=',$slug)->first();
                    $article->delete();
                  deleteLog(Article::class, $article->id);
                    return response()->json(['message' => ' Article supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Article::class,setZero());
        return response()->json(['message' => ' Article n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
