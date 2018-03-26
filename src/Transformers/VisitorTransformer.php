<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\Visitor;

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
        return [
            'id'        => (int) $record->id
        ];
    }
}
