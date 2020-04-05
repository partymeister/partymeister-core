<?php

namespace Partymeister\Core\Transformers\Components;

use League\Fractal;
use Partymeister\Core\Models\Visitor;

/**
 * Class PageTransformer
 * @package Motor\CMS\Transformers
 */
class VisitorListTransformer extends Fractal\TransformerAbstract
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
     * @return array
     */
    public function transform($record)
    {
        $data = [
            'component' => $record->component_name,
            'container' => $record->container,
            'content'   => [],
        ];
        foreach (Visitor::orderBy('created_at', 'DESC')->get() as $record) {
            $data['content'][] = [
                'handle'  => $record->name,
                'groups'  => $record->group,
                'country' => $record->country_iso_3166_1,
            ];
        }

        return $data;
    }
}
