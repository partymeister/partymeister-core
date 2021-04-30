<?php

namespace Partymeister\Core\Events;

use Illuminate\Queue\SerializesModels;
use Partymeister\Core\Models\Visitor;

/**
 * Class VisitorRegistered
 *
 * @package Partymeister\Core\Events
 */
class VisitorRegistered
{
    use SerializesModels;

    /**
     * @var Visitor
     */
    public $visitor;

    /**
     * VisitorRegistered constructor.
     *
     * @param Visitor $visitor
     */
    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }
}
