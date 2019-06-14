<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Http\Resources\Image as ImageResource;
use App\Image;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ImageController
|
|
|
|*/


class ImageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

                if(!ImageResource::collection(Image::paginate(10))->isEmpty()){
                   fetchLog(Image::class);
                    return response()->json(['content'=>Image::orderBy('created_at','desc')->paginate(10),'message'=>'liste des Images'],200,['Content-Type'=>'application/json']);

                }
                fetchEmptyLog(Image::class);
                return response()->json(['message'=>'Images empty']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $data = ['nom' =>$request->nom, 'alt'=>$request->nom, 'owner'=>$request->owner,'slug'=>str_slug(name_generator('image',10),'-')];
       if (Image::create($data)) {
                 createLog(Image::class);
                  return response()->json(['message' => ' Image crée avec succès'],200,['Content-Type'=>'application/json']);

              }
       createFailureLog( Image::class);
       return response()->json(['message'=>'echec de création Image']);
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
            if (Image::where('slug','=',$slug)->first()){
            $id = Image::where('slug','=',$slug)->first()->id;
            showLog(Image::class,$id);
            return response()->json(['content'=>new ImageResource(Image::where('slug','=',$slug)->first()),'message'=>'détail Image'],200,['Content-Type'=>'application/json']);
            }

          notFoundLog(Image::class,$id);
          return response()->json(['message' => 'echec ,Image n\existe pas'],404,['Content-Type'=>'application/json']);
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
          if (Image::where('slug','=',$slug)->first()){
           $image = Image::where('slug','=',$slug)->first();
           $data = ['nom' =>$request->nom, 'alt'=>$request->nom, 'owner'=>$request->owner,'slug'=>str_slug(name_generator('image',10),'-')];
           if ($image->update($data)){
               $image =Image::where('slug','=',$slug)->first();
               updateLog(Image::class,$image->id);
               return response()->json(['message' => ' Image mise à jours avec succès !'],200,['Content-Type'=>'application/json']);
           }else{
          updateFailureLog(Image::class,$image->id);
          return response()->json(['message' => ' echec mise à jours Image  !'],400,['Content-Type'=>'application/json']);
       }

       }

      notFoundLog(Image::class,setZero());
      return response()->json(['message' => ' Image n\'existe pas !'],404,['Content-Type'=>'application/json']);
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
              if (Image::where('slug','=',$slug)->first()){
                    $image = Image::where('slug','=',$slug)->first();
                    $image->delete();
                    deleteLog(Image::class,$id);
                    return response()->json(['message' => ' Image supprimé avec succès'],200,['Content-Type'=>'application/json']);
               }

         deleteFailureLog(Image::class,setZero());
        return response()->json(['message' => ' Image n\'existe pas !'],404,['Content-Type'=>'application/json']);
    }


}
