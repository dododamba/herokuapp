<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Annonce as AnnonceResource;
use App\Annonce;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   AnnonceController
|
|
|
|*/


class AnnonceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!AnnonceResource::collection(Annonce::paginate(10))->isEmpty()){
                  // fetchLog(Annonce::class);
                    return response()->json(['content'=>Annonce::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Annonces'],200,['Content-Type'=>'application/json']);

                }
                //fetchEmptyLog(Annonce::class);
                return response()->json(['message'=>'Annonces empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
      $data = [
          'titre' => $this->titre,
          'contenue' => $this->contenue,
          'dateDebut' => $this->dateDebut,
          'dateFin' => $this->dateFin,
          'prix' => $this->prix,
          'nombreCaratere' => strlen($this->contenue),
          'position' => $this->position,
          'etat' => $this->etat,
          'date_validation' => $this->date_validation,
          'utilisateur' => $this->utilisateur,
          'transaction' => $this->transaction,
          'image' => $this->image,
          'type_annonce' => $this->type_annonce,
          'partenaire' => $this->partenaire,
          'valider_par' => $this->valider_par,
          'slug' =>str_slug(name_generator('annonce',10),'-'),
      ];
        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'titre' => 'required|string|min:2|max:100',
            'contenu'=> 'required|string|min:2',
            'date_debut'=> 'required|date',
            'date_fin'=> 'required|date',
            'type_annonce'=> 'required|integer',
            'partenaire'=> 'required|integer',

        ];

        $messages = [
            'titre.required' => 'Le champ titre est obligatoire !',
            'titre.string' => 'Le champ titre doit contenir des chaines de charactères !',
            'titre.min' => 'Le champ titre doit contenir au moins deux charactères !',
            'contenu.required' => 'Le champ contenu est obligatoire !',
            'contenu.string' => 'Le champ contenu doit contenir des chaines de charactères !',
            'contenu.min' => 'Le champ contenu doit contenir au moins deux charactères !',
            'titre.max' => 'Le champ titre ne doit pas exceder 100 charactères !',
            'date_debut.date' => 'La date de debut est invalide',
            'date_debut.require' => 'La date de debut est obligatoire',
            'date_fin.date' => 'La date de fin est invalide',
            'date_fin.require' => 'La date de fin est obligatoire',
            'partenaire.required' => 'Partenaire non conforme !',
            'partenaire.integer' => 'donnée partenaire non conforme !',
            'type_annonce.required' => 'Le type est obligatoire !',
            'type_annonce.integer' => 'donnée type annonce non conforme !',
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
       if (Annonce::create($data)) {
                  createLog(Annonce::class);
                  return response()->json(['message' => ' Annonce crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog(Annonce::class);
       return response()->json(['message'=>'echec de création Annonce']);
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
            if (Annonce::where('slug','=',$slug)->first()){
            $id = Annonce::where('slug','=',$slug)->first()->id;
            showLog(Annonce::class,$id);
            return response()->json(['content'=>new AnnonceResource(Annonce::where('slug','=',$slug)->first()),'message'=>'détail Annonce'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Annonce::class);
          return response()->json(['message' => 'echec ,Annonce n\existe pas'],404,['Content-Type'=>'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */


    public function update(Request $request,$slug)
    {
          if (Annonce::where('slug','=',$slug)->first()){
           $annonce = Annonce::where('slug','=',$slug)->first();
           $data = [
               'titre' => $this->titre,
               'contenue' => $this->contenue,
               'dateDebut' => $this->dateDebut,
               'dateFin' => $this->dateFin,
               'prix' => $this->prix,
               'nombreCaratere' => $this->nombreCaratere,
               'position' => $this->position,
               'etat' => $this->etat,
               'date_validation' => $this->date_validation,
               'utilisateur' => $this->utilisateur,
               'transaction' => $this->transaction,
               'image' => $this->image,
               'type_annonce' => $this->type_annonce,
               'partenaire' => $this->partenaire,
               'valider_par' => $this->valider_par,
               'slug' =>str_slug(name_generator('annonce',10),'-'),
           ];

           if ($annonce->update($data)){
               $annonce =Annonce::where('slug','=',$slug)->first();
               updateLog(Annonce::class,$annonce->id);
               return response()->json(['message' => ' Annonce mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Annonce::class,$annonce->id);
          return response()->json(['message' => ' echec mise à jours Annonce  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Annonce::class,setZero());
      return response()->json(['message' => ' Annonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy(Request $request,$slug)
     {
              if (Annonce::where('slug','=',$slug)->first()){
                    $annonce = Annonce::where('slug','=',$slug)->first();
                    $annonce->delete();
                    deleteLog(Annonce::class);
                    return response()->json(['message' => ' Annonce supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Annonce::class,setZero());
        return response()->json(['message' => ' Annonce n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
