<?php

namespace Partymeister\Core\Components;

use Illuminate\Http\Request;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Models\Visitor;

class ComponentVisitorLists {

    protected $pageVersionComponent;
    protected $visitors;

    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }

    public function index(Request $request)
    {
        $this->visitors = Visitor::orderBy('created_at', 'DESC')->get();
        return $this->render();
    }

    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), ['visitors' => $this->visitors]);
    }

}
