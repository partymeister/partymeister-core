<?php

namespace Partymeister\Core\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Forms\Component\VisitorRegistrationForm;
use Partymeister\Core\Services\Component\VisitorRegistrationService;

/**
 * Class ComponentVisitorRegistrations
 *
 * @package Partymeister\Core\Components
 */
class ComponentVisitorRegistrations
{
    use FormBuilderTrait;

    /**
     * @var PageVersionComponent
     */
    protected $pageVersionComponent;

    /**
     * @var
     */
    protected $visitorRegistrationForm;

    /**
     * @var
     */
    protected $request;

    /**
     * ComponentVisitorRegistrations constructor.
     *
     * @param PageVersionComponent $pageVersionComponent
     */
    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }

    /**
     * @param Request $request
     * @return bool|Factory|RedirectResponse|View
     */
    public function index(Request $request)
    {
        $this->request = $request;

        $this->visitorRegistrationForm = $this->form(VisitorRegistrationForm::class, [
            'name'    => 'visitor-registration',
            'method'  => 'POST',
            'enctype' => 'multipart/form-data',
        ]);

        switch ($request->method()) {
            case 'POST':
                $result = $this->post();
                if ($result instanceof RedirectResponse) {
                    return $result;
                }
                break;
        }

        return $this->render();
    }

    /**
     * @return bool|RedirectResponse
     */
    protected function post()
    {
        if (is_null($this->request->get('visitor-registration'))) {
            return true;
        }

        if (! $this->visitorRegistrationForm->isValid()) {
            return redirect()
                ->back()
                ->withErrors($this->visitorRegistrationForm->getErrors())
                ->withInput();
        }
        VisitorRegistrationService::register($this->request->get('visitor-registration'));

        return redirect()->back();
    }

    /**
     * @return Factory|View
     */
    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), ['visitorRegistrationForm' => $this->visitorRegistrationForm]);
    }
}
