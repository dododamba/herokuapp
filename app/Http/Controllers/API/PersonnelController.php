<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\Personnel as PersonnelResource;
use App\Personnel;

use App\Role;

use App\User;
use App\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Sentinel;
use Activation;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   PersonnelController
|
|
|
|*/


class PersonnelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $personnels = Personnel::orderBy('id', 'desc')->paginate(6);
        $roles = Role::where('name', '<>', 'client')
            ->where('name', '<>', 'Admin')
            ->where('name', '<>', 'Client')
            ->where('name', '<>', 'admin')
            ->get();
        if (!PersonnelResource::collection($personnels)->isEmpty()) {
            fetchLog(Personnel::class);
            return response()->json(
                [
                    'content' => [
                        'personnels' => $personnels,
                        'roles' => $roles,
                    ]
                ],
                200,
                ['Content-Type' => 'application/json']
            );
        }
        fetchEmptyLog(Personnel::class);
        return response()->json(['content' => [
            'message' => 'Liste vide',
            'roles' => $roles,
        ]]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $assert_false = 0;
        $assert_true = 1;

        $data = [
            'matricule' => $request->matricule,
            'date_embauche' => $request->date_embauche,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'slug' => str_randomize(10),
            'email' => $request->email,
            'role' => $request->role,
            'telephone' => $request->telephone,
            'langue' => $request->langue,
            'sexe' => $request->sexe,
            'date_naissance' => $request->date_naissance
        ];

        $rules = [
            'nom' => 'required|string|min:2|max:100',
            'prenom' => 'required|string|min:2|max:100',
            'matricule' => 'required|string|min:2|max:8|unique:personnels',
            'date_embauche' => 'required|date',
            'email' => 'required|string|email|unique:users',
            'date_naissance' => 'date',
            'role' => 'required'

        ];

        $messages = [
            'nom.required' => 'Le champ nom est obligatoire !',
            'matricule.required' => 'Le champ matricule est obligatoire !',
            'date_embauche.required' => 'Le champ date embauche est obligatoire !',
            'matricule.unique' => 'Ce matricule est déja occupé !',
            'email.unique' => 'Cette adresse email est déja occupé !',
            'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
            'prenom.required' => 'Le champ prenom est obligatoire !',
            'prenom.string' => 'Le champ nom doit contenir des chaines de charactères !',
            'prenom.min' => 'Le champ nom doit contenir au moins deux charactères !',
            'prenom.max' => 'Le champ prenom ne doit pas exceder 100 charactères !',
            'email.required' => 'Le champ  email est obligatoire ! ',
            'email.email' => 'L\'adresse email est invalide',
            'date_naissance.date' => 'La date de naissance est invalide',
            'date_embauche.date' => 'La date d\'embauche est invalide',
            'role.required' => 'Attribuer un role SVP !'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(
                [
                    'content' => [
                        'error' => $validator->errors(),
                        'status' => $assert_false,
                        'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                    ]
                ]
            );
        }

        $data_user = [
            'matricule' => $data['matricule'],
            'date_embauche' => $data['date_embauche'],
            'email' => $data['email'],
            'password' => Hash::make('default-for-admin-only'),
            'slug' => $data['slug'],
            'langue' => $data['langue'],
            'telephone' => $data['telephone'],
            'remember_token' => str_slug(name_generator('token', 50), '_'),
            'role' => (integer)$data['role']
        ];


        $user = User::create($data_user);

        if (User::where('slug', $data_user['slug'])->first()) {
            $user_ = User::where('slug', $data_user['slug'])->first();
            $role_ = $user_->role;
            $data_ = [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'sexe' => $data['sexe'],
                'matricule' => $data['matricule'],
                'date_embauche' => $data['date_embauche'],
                'slug' => str_randomize(10),
                'user_id' => $user_->id,
                'date_naissance' => $data['date_naissance']
            ];

            Personnel::create($data_);

            if ($user) {
                $user->roles()->sync([$role_]);
                return response()->json(['message' => 'Personnel ajouté avec succès', 'status' => $assert_true]);
            }
            return response()->json(
                [
                    'error' => 'La création du compte personnel n\'est pas terminé, vueillé recommencer !',
                    'status' => $assert_false
                ]);
        }
        return response()->json(['error' => 'erreur creation personnel, recommencez svp !', 'status' => $assert_false]);
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
        if (Personnel::where('slug', '=', $slug)->first()) {
            $personnel = Personnel::where('slug', '=', $slug)->first();
            if ($personnel->update($data)) {
                $personnel = Personnel::where('slug', '=', $slug)->first();
                $data = [
                    // 'nom' =>$request->,
                    'prenom' => $request->prenom,
                    'date_embauche' => $request->date_embauche,
                    'etat' => $request->etat,
                    'date_naissance' => $request->date_naissance,
                    'matricule' => $request->matricule,
                    'slug' => str_slug(name_generator('personnel', 10), '-')
                ];
                updateLog(Personnel::class, $personnel->id);
                return response()->json(['message' => ' Personnel mise à jours avec succès !'], 200, ['Content-Type' => 'application/json']);
            } else {
                updateFailureLog(Personnel::class, $personnel->id);
                return response()->json(['message' => ' echec mise à jours Personnel  !'], 400, ['Content-Type' => 'application/json']);
            }

        }

        notFoundLog(Personnel::class, setZero());
        return response()->json(['message' => ' Personnel n\'existe pas !'], 404, ['Content-Type' => 'application/json']);
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
            $personel_slug = $user->getAffiliatePersonnel->slug;
            $personel = Personnel::where('slug', $personel_slug)->first();
            if ($user->delete() && $personel->delete()) {
                return response()->json(['message' => ' !!! Ce utilisateur a ete suprrimé avec succès !!!'], 200, ['Content-Type' => 'application/json']);
            }

            return response()->json(['message' => 'Erreur de suppression recommencer']);

        }

        deleteFailureLog(Personnel::class, setZero());
        return response()->json(['message' => ' !!! Client n\'existe pas !!!'], 404, ['Content-Type' => 'application/json']);
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
