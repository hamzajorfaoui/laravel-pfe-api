<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Filiere;
use Illuminate\Http\Resources\Json\JsonResource;

class ActualiteCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       


        return [

           
            'id' => $this->id,
            'title' => $this->title,
            'contenu' => $this->contenu,
            'filieres' =>  Filiere::find($this->filiers()->allRelatedIds()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
