<?php

namespace App\Http\Controllers\API;

use App\Agence;
use App\Client;
use App\Http\Controllers\Controller;

use App\Http\Resources\Partenaire as PartenaireResource;
use App\Partenaire;
use App\Personnel;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   PartenaireController
|
|
|
|*/


class PartenaireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if (!PartenaireResource::collection(Partenaire::all())->isEmpty()) {
            fetchLog(Partenaire::class);
            return response()->json([
                'content' => Partenaire::orderBy('nom_partenaire', 'desc')->get(),
                'message' => 'liste des Partenaires'],
                200,
                ['Content-Type' => 'application/json']);

        }
        fetchEmptyLog(Partenaire::class);
        return response()->json(['message' => 'Partenaires empty']);

    }


    /***
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $assert_false = 0;
        $assert_true = 1;

        /**
         *
         *  Ici les champs à valider, soumit depuis la requette post
         */

        $rules = [
            'name' => 'required|string|min:2|max:100',
            'type_partenaire' => 'required',
            'adresse_partenaire' => 'required',
            'description_partenaire' => 'required|string|min:30',
            'email' => 'required|string|email|unique:users',
            'logo' => 'mimes:jpeg,bmp,png',
            'libelle_agence' => 'required|string|min:2|max:100',
            'adresse_agence' => 'required|string|min:2',
            'email_agence' => 'email|unique:agences'
        ];

        /**
         *
         * Megasse de validation
         */
        $messages = [
            'name.required' => 'Le champ nom est obligatoire !',
            'name.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'name.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'name.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
            'email.required' => 'Le champ  email est obligatoire ! ',
            'email.email' => 'L\'adresse email est invalide',
            'email.unique' => 'Cette adresse email est déja occupé !',
            'email_agence.email' => 'L\'adresse email de L\'agence est invalide',
            'email_agence.unique' => 'Cette adresse email pour L\'agence est déja occupé !',
            'type_partenaire.required' => 'Le champ  type partenaire est obligatoire ! ',
            'adresse_partenaire.required' => 'Le champ  adresse partenaire est obligatoire ! ',
            'description_partenaire.required' => 'Le champ description est obligatoire !',
            'description_partenaire.string' => 'Le champ description doit contenir des chaines de charactères !',
            'description_partenaire.min' => 'Le champ description doit contenir au moins deux charactères !',
            'logo.mimes' => 'Choissiez un fichier de type jpeg, bmp ou png',
            'libelle.required' => 'Le champ libellé agence est obligatoire !',
            'libelle.string' => 'Le champ libellé agence doit contenir des chaines de charactères !',
            'libelle.min' => 'Le champ libellé agence doit contenir au moins deux charactères !',
            'libelle.max' => 'Le champ libellé agence ne doit pas exceder 100 charactères !',
            'adresse_agence.required' => 'Le champ nom est obligatoire !',
            'adresse_agence.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'adresse_agence.min' => 'Le champ nom doit contenir au moins deux charactères !',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        /**
         * Si le formulaire contient des erreur
         */
        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors(),
                    'status' => $assert_false,
                    'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                ]
            );
        }


        /**
         * sinon le code continue par s'executer
         */


        $data = [
            'email_user' => $request->email,
            'telephone_user' => $request->telephone,
            'langue_user' => $request->langue,
            'nom_partenaire' => $request->name,
            'type_partenaire' => $request->type_partenaire,
            'adresse_partenaire' => $request->adresse_partenaire,
            'description_partenaire' => $request->description,
            'site_web_partenaire' => $request->site_web,
            'etat_partenaire' => 1,
            'libelle_agence' => $request->libelle_agence,
            'adresse_agence' => $request->adresse_agence,
            'email_agence' => $request->email_agence,
            'ville_agence' => $request->ville_agence,

        ];

        /**
         * Determinons le role a affecter à l'utilisateur
         */
        $role = Role::where('name', 'Partenaire')->first();


        $data_user = [
            'email' => $data['email_user'],
            'password' => Hash::make('default-for-admin-only'),
            'slug' => str_randomize(20),
            'langue' => $data['langue_user'],
            'telephone' => $data['telephone_user'],
            'remember_token' => str_slug(name_generator('token', 50), '_'),
            'role' => $role->id,
        ];

        if ($request->has('logo')) {
            $var_image = $request->file('logo')->store('logos');
        } else {
            $var_image = NULL;
        }
        /**
         * Creation d'un compte utilisateur
         */
        $user = User::create($data_user);

        /**
         *
         * On fait une assertion si le user est créee avec succès
         * on Commence par créer un le partenaire
         * on recupère un compte precis avec le slug de $data_user (unique)
         */
        if (User::where('slug', $data_user['slug'])->first()) {
            $user_ = User::where('slug', $data_user['slug'])->first();
            $role_ = $user_->role;

            $data_partenaire = [
                'nom_partenaire' => $data['nom_partenaire'],
                'type_partenaire' => $data['type_partenaire'],
                'adresse' => $data['adresse_partenaire'],
                'description' => $data['description_partenaire'],
                'site_web' => $data['site_web_partenaire'],
                'slug' => str_randomize(20),
                'etat' => 1,
                'logo' => $var_image,
            ];

            Partenaire::create($data_partenaire);
            /**
             * On recupere le partenaire qu 'on vient de créer par son slug
             */
            $partenaire_ = Partenaire::where('slug', $data_partenaire['slug'])->first();

            $data_agence = [
                'libelle' => $data['libelle_agence'],
                'adresse' => $data['adresse_agence'],
                'email' => $data['email_agence'],
                'slug' => str_randomize(20),
                'ville' => $data['ville_agence'],
                'pays' => $data['pays_agence'],
                'partenaire' => $partenaire_->id
            ];

            /**
             * On crée l'agence
             */

            Agence::create($data_agence);

            /**
             * On syncronique le role et utilisateur qu'on
             * vient d'ajouter
             */

            if ($user) {
                $user->roles()->sync([$role_]);
                return response()->json(['message' => 'Partenaire ajouté avec succès', 'status' => $assert_true]);
            }
            return response()->json(
                [
                    'error' => 'L\'ajout du partenaire n\'est pas terminé, vueillé recommencer !',
                    'status' => $assert_false
                ]);
        }
        return response()->json(['error' => 'erreur  recommencez svp !', 'status' => $assert_false]);

    }

    /***
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activation(Request $request,$id)
    {

        $user = User::where('slug',$id)->first();
        $activation = Activation::completed($user);
        if($activation){
            return response()->json(['message' => 'Ce compte est déja activé']);
        }
        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);

        $role = $user->roles()->first()->name;
        return response()->json(['message' => 'Compte activé avec succès !']);
    }

    /***
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivation(Request $request,$id){
        $user = User::where('slug',$id)->first();
        Activation::remove($user);
        return response()->json(['message' => 'Le compte a été désactivé avec succès !']);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(Request $request, $slug)
    {
        if (Partenaire::where('slug', '=', $slug)->first()) {
            $id = Partenaire::where('slug', '=', $slug)->first()->id;
            showLog(Partenaire::class, $id);
            return response()->json(['content' => new PartenaireResource(Partenaire::where('slug', '=', $slug)->first()), 'message' => 'détail Partenaire'], 200, ['Content-Type' => 'application/json']);
        }

        notFoundLog(Partenaire::class);
        return response()->json(['message' => 'echec ,Partenaire n\existe pas'], 404, ['Content-Type' => 'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request,$slug)
    {
        if (Partenaire::where('slug', '=', $slug)->first()) {
            $partenaire = Partenaire::where('slug', '=', $slug)->first();
            if ($partenaire->update($request->all())) {
                $partenaire = Partenaire::where('slug', '=', $slug)->first();
                updateLog(Partenaire::class, $partenaire->id);
                return response()->json(['message' => ' Partenaire mise à jours avec succès !'], 200, ['Content-Type' => 'application/json']);
            } else {
                updateFailureLog(Partenaire::class, $partenaire->id);
                return response()->json(['message' => ' echec mise à jours Partenaire  !'], 400, ['Content-Type' => 'application/json']);
            }

        }

        notFoundLog(Partenaire::class, setZero());
        return response()->json(['message' => ' Partenaire n\'existe pas !'], 404, ['Content-Type' => 'application/json']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(Request $request, $slug)
    {
        if (!Partenaire::where('slug', $slug)->get()->isEmpty()) {
            $partenaire = Partenaire::where('slug', $slug)->first();


            // On récupère le user lié au partenaire

            if (!User::where('id', '=', $partenaire->utilisateur)->get()->isEmpty()) {
                $user = User::where('id', '=', $partenaire->utilisateur)->first();
                $user->delete();
            }


            // Récupération des agences du partenaire
            if (!Agence::where('partenaire', $partenaire->id)->get()->isEmpty()) {
                $agences = Agence::where('partenaire', $partenaire->id)->get();
                // On supprime toutes les agences
                foreach ($agences as $agence)
                    $agence->delete();
            }

            // on récupere l'id du partenaire pour le log
            $id = $partenaire->id;

            $partenaire->delete();

            deleteLog(Partenaire::class, $id);
            return response()->json(['message' => ' Partenaire supprimé avec succès'], 200, ['Content-Type' => 'application/json']);
        }

        deleteFailureLog(Partenaire::class, setZero());
        return response()->json(['message' => ' Partenaire n\'existe pas !'], 404, ['Content-Type' => 'application/json']);
    }


}
