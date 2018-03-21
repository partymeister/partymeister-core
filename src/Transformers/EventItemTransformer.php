<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\EventItem;

class EventItemTransformer extends Fractal\TransformerAbstract
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
     * @param EventItem $record
     *
     * @return array
     */
    public function transform(EventItem $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
