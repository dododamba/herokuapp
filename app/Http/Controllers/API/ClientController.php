<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

//use App\Http\Resources\Client as ClientResource;
use App\Client;
use App\Role;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Client as ClientResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Utilisateur;
use Illuminate\Http\Request;
use Sentinel;
use Activation;
use Redirect;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   Client Controller
|
|
|
|*/


class ClientController extends Controller
{

    public function index()
    {
        $clients = Client::orderBy('id', 'desc')->paginate(6);
        $role = Role::all();

        if (!ClientResource::collection($clients)->isEmpty()) {
            fetchLog(Client::class);
            return response()->json(

                [
                    'content' => [
                        'clients' => $clients,
                        'message' => 'liste des clients']

                ],
                200,
                [
                    'Content-Type' => 'application/json'
                ]);

        }
        fetchEmptyLog(Client::class);
        return response()->json(['message' => 'Utilisateur empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {


        $data = [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'slug' => str_randomize(10),
            'email' => $request->email,
            'role' => 2,
            'telephone' => $request->telephone,
            'langue' => $request->langue,
            'sexe' => $request->sexe,
            'date_naissance' => $request->date_naissance
        ];

        $assert_false = 0;
        $assert_true = 1;


        $rules = [
            'nom' => 'required|string|min:2|max:100',
            'prenom' => 'required|string|min:2|max:100',
            'email' => 'required|string|email',
            'date_naissance' => 'date'

        ];

        $messages = [
            'nom.required' => 'Le champ nom est obligatoire !',
            'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
            'prenom.required' => 'Le champ nom est obligatoire !',
            'prenom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'prenom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'prenom.required' => 'Le champ prenom doit contenir au plus cent charactères !',
            'prenom.max' => 'Le champ prenom ne doit pas exceder 100 charactères !',
            'email.required' => 'Le champ  email est obligatoire ! ',
            'email.email' => 'L\'adresse email est invalide',
            'date_naissance.date' => 'La date de naissance est invalide'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors(),
                    'status' => $assert_false,
                    'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                ]);
        }

        $data_user = [
            'email' => $data['email'],
            'password' => Hash::make('default-for-admin-only'),
            'slug' => $data['slug'],
            'langue' => $data['langue'],
            'telephone' => $data['telephone'],
            'remember_token' => str_slug(name_generator('token', 50), '_'),
            'role' => $data['role']
        ];

        $user = User::create($data_user);

        if (User::where('slug', $data_user['slug'])->first()) {
            $user_ = User::where('slug', $data_user['slug'])->first();
            $data_ = [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'sexe' => $data['sexe'],
                'slug' => str_randomize(10),
                'user_id' => $user_->id,
                'date_naissance' => $data['date_naissance']
            ];

            Client::create($data_);

            if ($user) {
                $user->roles()->sync([2]); // 2 = client
                return response()->json(['message' => 'Client ajouté avec succès', 'status' => $assert_true]);
            }
            return response()->json(['error' => 'La création du compte client n\'est pas terminé, vueillé recommencer !',
                'status' => $assert_false]);
        }
        return response()->json(['error' => 'erreur creation client, recommencez svp !'
            , 'status' => $assert_false]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function update(Request $request, $slug)
    {
        if (Client::where('slug', '=', $slug)->first()) {
            $client = Client::where('slug', '=', $slug)->first();
            $data = [
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'slug' => str_slug(name_generator('client', 10), '-'),
                'utilisateur' => $request->utilisateur
            ];
            if ($client->update($data)) {
                $client = Client::where('slug', '=', $slug)->first();
                updateLog(Client::class, $client->id);
                return response()->json(['message' => ' Client mise à jours avec succès !'], 200, ['Content-Type' => 'application/json']);
            } else {
                updateFailureLog(Client::class, $client->id);
                return response()->json(['message' => ' echec mise à jours Client  !'], 400, ['Content-Type' => 'application/json']);
            }

        }

        notFoundLog(Client::class, setZero());
        return response()->json(['message' => ' Client n\'existe pas !'], 404, ['Content-Type' => 'application/json']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function destroy(Request $request, $slug)
    {
        if (User::where('slug', '=', $slug)->first()) {
            $user = User::where('slug', '=', $slug)->first();
            $role = Role::where('id', '=', $user->role)->first();
            $client_slug = $user->getAffiliateClient->slug;
            if ($role->name === 'client') {
                $client = Client::where('slug', $client_slug)->first();
                $user->delete();
                $client->delete();
                return response()->json(['message' => ' !!! Ce utilisateur a ete suprrimé avec succès !!!'], 200, ['Content-Type' => 'application/json']);
            }
            return response()->json(['user' => $role]);

        }

        deleteFailureLog(Client::class, setZero());
        return response()->json(['error' => ' !!! Client n\'existe pas !!!'], 404, ['Content-Type' => 'application/json']);
    }


    public function activation(Request $request, $id)
    {

        $user = User::where('slug', $id)->first();
        $activation = Activation::completed($user);
        if ($activation) {
            return response()->json(['message' => 'Ce compte est déja activé']);
        }
        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);

        $role = $user->roles()->first()->name;
        return response()->json(['message' => 'Compte activé avec succès !']);
    }

    public function deactivation(Request $request, $id)
    {
        $user = User::where('slug', $id)->first();
        Activation::remove($user);
        return response()->json(['message' => 'Le compte a été désactivé avec succès !']);

    }

}
