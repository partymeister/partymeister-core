<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\Guest;

/**
 * Class GuestTransformer
 * @package Partymeister\Core\Transformers
 */
class GuestTransformer extends Fractal\TransformerAbstract
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
     * @param Guest $record
     *
     * @return array
     */
    public function transform(Guest $record)
    {
        return [
            'id'                  => (int) $record->id,
            'name'                => $record->name,
            'handle'              => $record->handle,
            'email'               => $record->email,
            'company'             => $record->company,
            'country'             => $record->country,
            'ticket_code'         => $record->ticket_code,
            'ticket_type'         => $record->ticket_type,
            'has_badge'           => (bool) $record->has_badge,
            'has_arrived'         => (bool) $record->has_arrived,
            'ticket_code_scanned' => (bool) $record->ticket_code_scanned,
            'comment'             => $record->comment,
            'arrived_at'          => $record->arrived_at,
            'category_id'         => (int) $record->category_id,

        ];
    }
}
