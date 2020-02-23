<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Departement;
use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
class ProfCollection extends JsonResource
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
            'name' => $this->fullname,
            'email' => User::find($this->user_id)->email,
            'fullname' => $this->fullname,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deptname' => Departement::find($this->departement_id)->name,
        ];
    }
}
