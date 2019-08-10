<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\Visitor;

/**
 * Class VisitorTransformer
 * @package Partymeister\Core\Transformers
 */
class VisitorTransformer extends Fractal\TransformerAbstract
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
     * @param Visitor $record
     *
     * @return array
     */
    public function transform(Visitor $record)
    {
        // FIXME: this should be updated to pm3 defaults after Revision 2018
        return [
            'id'      => (int) $record->id,
            'handle'  => $record->name,
            'groups'  => $record->group,
            'country' => $record->country_iso_3166_1,
            'uniqid'  => $record->api_token,
        ];
    }
}
