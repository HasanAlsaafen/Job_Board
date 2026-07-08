<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'company' => $this->company_name,
            'location' => $this->location,
            'type' => $this->type,
            'description' => $this->description,
            'tags' => $this->tags->pluck('name'),
            'posted_at' => $this->created_at->diffForHumans(),
        ];
    }
}
