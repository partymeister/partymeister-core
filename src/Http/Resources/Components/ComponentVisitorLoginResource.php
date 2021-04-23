<?php

namespace Partymeister\Core\Http\Resources\Components;

use Illuminate\Http\Resources\Json\JsonResource;

class ComponentVisitorLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'visitor_registration_page_id' => $this->visitor_registration_page_id,
            'entries_page_id'              => $this->entries_page_id,
            'voting_page_id'               => $this->voting_page_id,
            'comments_page_id'             => $this->comments_page_id,
        ];
    }
}
