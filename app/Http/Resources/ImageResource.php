<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => asset('storage/' . $this->path),
        ];
    }
}