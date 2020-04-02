<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Filiere;
use App\Semestre;
class TempCollection  extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $fill = Filiere::find($this->filiere_id);
        return [
            'id' => $this->id,
            'temp' => $this->temp,
            'fillier' => $fill->name .' '.$fill->niveau,
            'semester' => Semestre::find($this->semester_id)->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
