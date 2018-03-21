<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\EventType;

class EventTypeTransformer extends Fractal\TransformerAbstract
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
     * @param EventType $record
     *
     * @return array
     */
    public function transform(EventType $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
