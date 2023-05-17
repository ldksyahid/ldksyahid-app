<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'datepublish' => $this->datepublish,
            'publisher' => $this->publisher,
            'title' => $this->title,
            'reporter' => $this->reporter,
            'editor' => $this->editor,
            'picture' => $this->picture,
            'descpicture' => $this->descpicture,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
