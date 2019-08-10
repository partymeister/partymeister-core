<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\EventType;

/**
 * Class EventTypeTransformer
 * @package Partymeister\Core\Transformers
 */
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
            'id'          => (int) $record->id,
            'name'        => $record->name,
            'web_color'   => $record->web_color,
            'slide_color' => $record->slide_color
        ];
    }
}
