<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\Event;

class EventTransformer extends Fractal\TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];


    /**
     * Transform record to array
     *
     * @param Event $record
     *
     * @return array
     */
    public function transform(Event $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
