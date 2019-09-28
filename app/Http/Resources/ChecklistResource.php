<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'  =>  [
                'id'    =>  $this->id,
                'type'  =>  $this->type,
                'attributes' =>  $this->attributes,
                'links' =>  $this->links
            ]
        ];
    }
}
