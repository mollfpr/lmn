<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChecklistCollection extends ResourceCollection
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
            'data' => $this->collection,
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);

        $newMeta = [
            'count' =>  count($jsonResponse['data']),
            'total' =>  $jsonResponse['meta']['total']
        ];

        unset($jsonResponse['meta']);

        $jsonResponse['meta'] = $newMeta;

        $response->setContent(json_encode($jsonResponse));
    }
}
