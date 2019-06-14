<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Commentaire as CommentaireResource;
use App\Commentaire;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   CommentaireController
|
|
|
|*/


class CommentaireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!CommentaireResource::collection(Commentaire::paginate(10))->isEmpty()){
                   fetchLog(Commentaire::class);
                    return response()->json(['content'=>Commentaire::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Commentaires'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Commentaire::class);
                return response()->json(['message'=>'Commentaires empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = [
          'contenu' =>$request->contenu,
          'utilisateur' =>$request->utilisateur,
          'slug' =>str_slug(name_generator('commentaire',10),'-'),
          'article' =>$request->article
        ];

        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'contenu' => 'required|string|min:2',

        ];

        $messages = [
            'contenu.required' => 'Le champ contenu est obligatoire !',
            'contenu.string' => 'Le champ contenu doit contenir des chaines de charactères !',
            'contenu.min' => 'Le champ contenu doit contenir au moins deux charactères !'

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


       if (Commentaire::create($data)) {
                 createLog(Commentaire::class);
                  return response()->json(['message' => ' Commentaire crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( Commentaire::class);
       return response()->json(['message'=>'echec de création Commentaire']);
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
            if (Commentaire::where('slug','=',$slug)->first()){
            $id = Commentaire::where('slug','=',$slug)->first()->id;
            showLog(Commentaire::class,$id);
            return response()->json(['content'=>new CommentaireResource(Commentaire::where('slug','=',$slug)->first()),'message'=>'détail Commentaire'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Commentaire::class,$id);
          return response()->json(['message' => 'echec ,Commentaire n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (Commentaire::where('slug','=',$slug)->first()){
           $commentaire = Commentaire::where('slug','=',$slug)->first();
           $data = [
             'contenu' =>$request->contenu,
             'utilisateur' =>$request->utilisateur,
             'slug' =>str_slug(name_generator('commentaire',10),'-'),
             'article' =>$request->article
           ];
           if ($commentaire->update($data)){
               $commentaire =Commentaire::where('slug','=',$slug)->first();
               updateLog(Commentaire::class,$commentaire->id);
               return response()->json(['message' => ' Commentaire mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Commentaire::class,$commentaire->id);
          return response()->json(['message' => ' echec mise à jours Commentaire  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Commentaire::class,setZero());
      return response()->json(['message' => ' Commentaire n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Commentaire::where('slug','=',$slug)->first()){
                    $commentaire = Commentaire::where('slug','=',$slug)->first();
                    $commentaire->delete();
                    deleteLog(Commentaire::class,$id);
                    return response()->json(['message' => ' Commentaire supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Commentaire::class,setZero());
        return response()->json(['message' => ' Commentaire n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
