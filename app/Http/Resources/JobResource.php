<?php

namespace App\Http\Resources;

use App\Http\Resources\EmployerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'title' => $this->title,
            'description' => $this->description,
            'salary' => $this->salary,
            'location' => $this->location,
            'category' => $this->experience,
            'created_at' => $this->created_at,
            'employer' => new EmployerResource($this->whenLoaded('employer'))
        ];
    }
}
