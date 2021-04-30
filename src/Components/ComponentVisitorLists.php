<?php

namespace Partymeister\Core\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Models\Visitor;

/**
 * Class ComponentVisitorLists
 *
 * @package Partymeister\Core\Components
 */
class ComponentVisitorLists
{
    /**
     * @var PageVersionComponent
     */
    protected $pageVersionComponent;

    /**
     * @var
     */
    protected $visitors;

    /**
     * ComponentVisitorLists constructor.
     *
     * @param PageVersionComponent $pageVersionComponent
     */
    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $this->visitors = Visitor::orderBy('created_at', 'DESC')
                                 ->get();

        return $this->render();
    }

    /**
     * @return Factory|View
     */
    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), ['visitors' => $this->visitors]);
    }
}
