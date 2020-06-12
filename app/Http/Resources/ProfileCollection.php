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
        $filiere =Filiere::find($this->filiere_id);
        return [
            // 'id' => $this->id,
            'fullname' => $this->fullname,
            'cin' => $this->cin,
            'cne' => $this->cne,
            'fillier' => $filiere->name." ".$filiere->niveau,
            'email' => User::find($this->user_id)->email,
        ];
    }
}
