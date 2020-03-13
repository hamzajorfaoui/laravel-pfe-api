<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

use App\User;
use App\Filiere;
class ProfileCollection  extends JsonResource
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
            'fullname' => $this->fullname,
            'cin' => $this->cin,
            'cne' => $this->cne,
            'fillier' => Filiere::find($this->filiere_id)->name,
            'email' => User::find($this->user_id)->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
