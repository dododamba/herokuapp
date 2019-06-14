<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\Billet as BilletResource;
use App\Billet;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   BilletController
|
|
|
|*/


class BilletController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if (!BilletResource::collection(Billet::paginate(10))->isEmpty()) {
            fetchLog(Billet::class);
            return response()->json(['content' => Billet::orderBy('created_at', 'desc')->paginate(10), 'message' => 'liste des Billets'], 200, ['Content-Type' => 'application/json']);

        }
        fetchEmptyLog(Billet::class);
        return response()->json(['message' => 'Billets empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = [
            'code_barre' => $request->code_barre,
            'validite' => $request->validite,
            'slug' => str_slug(name_generator('billet', 10), '-'),
            'reservation_voyage' => $request->reservation_voyage,
            'resevation_location' => $request->resevation_location
        ];

        $assert_false = 0;
        $assert_true = 1;

        $rules = [
            'code_barre' => 'required|string|min:2|max:100',

        ];

        $messages = [
            'code_barre.required' => 'Le champ code_barre est obligatoire !',
            'code_barre.string' => 'Le champ code_barre doit contenir des chaines de charactères !',
            'code_barre.min' => 'Le champ code_barre doit contenir au moins deux charactères !',
            'code_barre.max' => 'Le champ code_barre ne doit pas exceder 100 charactères !',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors(),
                    'status' => $assert_false,
                    'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                ]
            );
        }

        if (Billet::create($data)) {
            createLog(Billet::class);
            return response()->json(['message' => ' Billet crée avec succès'], 200, ['Content-Type' => 'application/json']);

        }
        createFailureLog(Billet::class);
        return response()->json(['message' => 'echec de création Billet']);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     *
     * @return Response
     */
    public function show(Request $request, $slug)
    {
        if (Billet::where('slug', '=', $slug)->first()) {
            $id = Billet::where('slug', '=', $slug)->first()->id;
            showLog(Billet::class, $id);
            return response()->json(['content' => new BilletResource(Billet::where('slug', '=', $slug)->first()), 'message' => 'détail Billet'], 200, ['Content-Type' => 'application/json']);
        }

        notFoundLog(Billet::class);
        return response()->json(['message' => 'echec ,Billet n\existe pas'], 404, ['Content-Type' => 'application/json']);
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
        if (Billet::where('slug', '=', $slug)->first()) {
            $billet = Billet::where('slug', '=', $slug)->first();
            if ($billet->update($request->all())) {
                $data = [
                    'code_barre' => $request->code_barre,
                    'validite' => $request->validite,
                    'slug' => str_slug(name_generator('billet', 10), '-'),
                    'reservation_voyage' => $request->reservation_voyage,
                    'resevation_location' => $request->resevation_location
                ];

                if ($billet->update($data)) {
                    $billet = Billet::where('slug', '=', $slug)->first();
                    updateLog(Billet::class, $billet->id);
                    return response()->json(['message' => ' Billet mise à jours avec succès !'], 200, ['Content-Type' => 'application/json']);
                } else {
                    updateFailureLog(Billet::class, $billet->id);
                    return response()->json(['message' => ' echec mise à jours Billet  !'], 400, ['Content-Type' => 'application/json']);
                }

            }

            notFoundLog(Billet::class, setZero());
            return response()->json(['message' => ' Billet n\'existe pas !'], 404, ['Content-Type' => 'application/json']);
        }
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
        if (Billet::where('slug', '=', $slug)->first()) {
            $billet = Billet::where('slug', '=', $slug)->first();
            $billet->delete();
            deleteLog(Billet::class);
            return response()->json(['message' => ' Billet supprimé avec succès'], 200, ['Content-Type' => 'application/json']);
        }

        deleteFailureLog(Billet::class, setZero());
        return response()->json(['message' => ' Billet n\'existe pas !'], 404, ['Content-Type' => 'application/json']);
    }


}
