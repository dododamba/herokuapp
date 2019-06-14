<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Role as RoleResource;
use App\Personnel;
use App\Role;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   RoleController
|
|
|
|*/


class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!RoleResource::collection(Role::paginate(10))->isEmpty()){
                   fetchLog(Role::class);
                    return response()->json(['content'=>Role::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Roles'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Role::class);
                return response()->json(['message'=>'Roles empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = ['nom' =>$request->nom, 'description' =>$request->description,'slug' =>str_slug(name_generator('role',10),'-')];

       if (Role::create($data)) {
                 createLog(Role::class);
                  return response()->json(['message' => ' Role crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog(Role::class);
       return response()->json(['message'=>'echec de création Role']);
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
            if (Role::where('slug','=',$slug)->first()){
            $id = Role::where('slug','=',$slug)->first()->id;
            showLog(Role::class,$id);
            return response()->json(['content'=>new RoleResource(Role::where('slug','=',$slug)->first()),'message'=>'détail Role'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Role::class,$id);
          return response()->json(['message' => 'echec ,Role n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (Role::where('slug','=',$slug)->first()){
           $role = Role::where('slug','=',$slug)->first();
           $data = ['nom' =>$request->nom, 'description' =>$request->description,'slug' =>str_slug(name_generator('role',10),'-')];
           if ($role->update($data)){
               $role =Role::where('slug','=',$slug)->first();
               updateLog(Role::class,$role->id);
               return response()->json(['message' => ' Role mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Role::class,$role->id);
          return response()->json(['message' => ' echec mise à jours Role  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Role::class,setZero());
      return response()->json(['message' => ' Role n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Role::where('slug','=',$slug)->first()){
                    $role = Role::where('slug','=',$slug)->first();
                    $role->delete();
                    deleteLog(Role::class,$id);
                    return response()->json(['message' => ' Role supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Role::class,setZero());
        return response()->json(['message' => ' Role n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }

    public function personnel()
    {
        $roles = Role::where('name', '<>', 'client')
            ->where('name', '<>', 'Admin')
            ->where('name', '<>', 'Client')
            ->where('name', '<>', 'admin')
            ->get();

        return response()->json(
            [
                'content' => [
                    'roles' => $roles
                ]
            ]
        );
    }

}
