<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Filiere;
use App\Semestre;
class ExmenCollection extends JsonResource
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
            'temp' => $this->examen	,
            'fillier' => Filiere::find($this->filiere_id)->name,
            'semester' => Semestre::find($this->semester_id)->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
