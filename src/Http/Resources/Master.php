<?php

namespace Knovators\Masters\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Knovators\Media\Http\Resources\Media as MediaResource;

/**
 * Class Master
 * @package Knovators\Masters\Http\Resources
 */
class Master extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'code'        => $this->code,
            'is_active'   => $this->is_active,
            'image'       => new MediaResource($this->whenLoaded('image')),
            'sub_masters' => new MasterCollection($this->whenLoaded('childMasters'))
        ];
    }
}
