<?php

namespace Partymeister\Core\Transformers;

use League\Fractal;
use Partymeister\Core\Models\MessageGroup;

class MessageGroupTransformer extends Fractal\TransformerAbstract
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
     * @param MessageGroup $record
     *
     * @return array
     */
    public function transform(MessageGroup $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
