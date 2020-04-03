<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filiere;
use App\Matiere;
use App\User;
use App\Actualite;
use App\Image;
use App\Http\Resources\ActualiteCollection;

class ActualiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    
        


        $actualites = Actualite::all();
        return ActualiteCollection::collection($actualites);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //user
        $idu=auth('api')->user()->id;
        $user = User::find($idu);
       
        $actualite = new Actualite;
        $actualite->is_active           = 1 ;
        if($file = $request->file('req_image')){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $actualite->req_image = '/temps/'. $name;
        }else {
            $actualite->req_image = null;
        }

        
        //actualite
       
        $actualite->title = $request->title;
        $actualite->contenu = $request->contenu;
        $user->actualites()->save($actualite);

        //table id filiiers


        $filiers_id = $request->filiers_id;
        

     
        foreach ($filiers_id as $id) {

            $filiere = Filiere::find($id);

             $actualite->filiers()->save($filiere);
            
        }


     if($images = $request->file('image_act')){

         foreach ($images as $image) {

            $imageT = new Image;
            $name = time() . $image->getClientOriginalName();
            $image->move('images', $name);

            
            $imageT->image = '/images/'. $name;

            $actualite->images()->save($imageT);
            
        }
            
        }

 
        return $actualite;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         
        return $actualite = Actualite::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $actualite = Actualite::find($id);
        if($request->title != null){
            $actualite->title = $request->title;
        }
        if($request->contenu != null){
            $actualite->contenu = $request->contenu;
        }



        $actualite->save();

        return ActualiteCollection::collection(Actualite::where('id',$actualite->id)->get());

    }

    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actualite = Actualite::findOrFail($id);
        $actualite->delete();
        return response()->json(['succes' => true]);
    }


    //*******************||   Student Side    ||***********************


    public function actualitesbyfillier(){
         $etudiant = auth('api')->user()->etudiant;
         $fili = Filiere::find($etudiant->filiere_id);
         $act = $fili->actualite()->get();
         return response()->json(['actualities' => $act]);
    
    }

    public function active($id)
    {
        $actualite = Actualite::findOrFail($id);
        if($actualite != null){

            if($actualite->is_active == 0){
                $actualite->is_active = 1 ;
                $actualite->save();
                return response()->json(['is_active' => true]);

            }
            if($actualite->is_active == 1){
                $actualite->is_active = 0 ;
                $actualite->save();
                return response()->json(['is_active' => false]);
            }
        }else{
            return response()->json(['error' => "actualite not found"]);
        }
        
    }

}
