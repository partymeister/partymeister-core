<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\Schedule;

/**
 * Class ScheduleTransformer
 * @package Partymeister\Core\Transformers
 */
class ScheduleTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [ 'events' ];

    /**
     * @var array
     */
    protected $defaultIncludes = [ 'events' ];


    /**
     * Transform record to array
     *
     * @param Schedule $record
     *
     * @return array
     */
    public function transform(Schedule $record)
    {
        return [
            'id'   => (int) $record->id,
            'name' => $record->name
        ];
    }


    /**
     * @param Schedule $record
     * @return Fractal\Resource\Collection
     */
    public function includeEvents(Schedule $record)
    {
        $collection = $record->events()
                             ->orderBy('starts_at', 'ASC')
                             ->orderBy('sort_position', 'ASC')
                             ->orderBy('event_type_id', 'ASC')
                             ->orderBy('name', 'ASC')
                             ->get();

        if ( ! is_null($collection)) {
            return $this->collection($collection, new EventTransformer());
        }
    }
}
