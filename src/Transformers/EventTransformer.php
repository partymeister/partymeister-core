<?php

namespace Partymeister\Core\Transformers;

use Carbon\Carbon;
use League\Fractal;
use Partymeister\Core\Models\Event;

/**
 * Class EventTransformer
 * @package Partymeister\Core\Transformers
 */
class EventTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [ 'event_type' ];

    protected $defaultIncludes = [ 'event_type' ];


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
            'id'                => (int) $record->id,
            'name'              => $record->name,
            'starts_at'         => Carbon::createFromTimestamp(strtotime($record->starts_at))->toIso8601String(),
            'ends_at'           => $record->ends_at,
            'is_visible'        => (bool) $record->is_visible,
            'is_organizer_only' => (bool) $record->is_organizer_only
        ];
    }


    /**
     * @param Event $record
     * @return Fractal\Resource\Item
     */
    public function includeEventType(Event $record)
    {
        return $this->item($record->event_type, new EventTypeTransformer());
    }
}
