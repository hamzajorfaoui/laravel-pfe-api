<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Annonce;
use App\TypeAnnonce;
use App\User;
use App\Prof;
use App\Filiere;
use App\Matiere;

class AnnonceCollection extends JsonResource
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
            'date_prevue' => $this->date_prevue,
            'date_auralieu' => $this->date_auralieu,
            'salle' => $this->salle,
            'user' => User::find($this->user_id)->name,
            'typeannonce' => TypeAnnonce::find($this->typeannonce_id)->type,
            'matiere' => Matiere::find($this->matiere_id)->name,
            'prof' => Prof::find($this->prof_id)->fullname,
            'filiere' => Filiere::find($this->filiere_id)->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
