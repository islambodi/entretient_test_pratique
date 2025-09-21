<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'description' => $this->description,
            'status'    => $this->status,
            'deadline'  => $this->deadline,
            'user'      => $this->user->name,
            'created_at'=> $this->created_at->toDateTimeString(),
        ];
    }
}
