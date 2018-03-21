<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\Schedule;

class ScheduleTransformer extends Fractal\TransformerAbstract
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
     * @param Schedule $record
     *
     * @return array
     */
    public function transform(Schedule $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
