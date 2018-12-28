<?php

namespace Partymeister\Core\Events;

use Illuminate\Queue\SerializesModels;
use Partymeister\Core\Models\Visitor;

class VisitorRegistered
{
    use SerializesModels;

    public $visitor;

    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }
}