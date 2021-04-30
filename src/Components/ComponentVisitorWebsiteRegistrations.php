<?php

namespace Partymeister\Core\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Forms\Component\VisitorWebsiteRegistrationForm;
use Partymeister\Core\Services\Component\VisitorWebsiteRegistrationService;

/**
 * Class ComponentVisitorWebsiteRegistrations
 *
 * @package Partymeister\Core\Components
 */
class ComponentVisitorWebsiteRegistrations
{
    use FormBuilderTrait;

    /**
     * @var PageVersionComponent
     */
    protected $pageVersionComponent;

    /**
     * @var
     */
    protected $visitorWebsiteRegistrationForm;

    /**
     * @var
     */
    protected $request;

    /**
     * ComponentVisitorWebsiteRegistrations constructor.
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

        $this->visitorWebsiteRegistrationForm = $this->form(VisitorWebsiteRegistrationForm::class, [
            'name'    => 'visitor-website-registration',
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
        if (is_null($this->request->get('visitor-website-registration'))) {
            return true;
        }

        if (! $this->visitorWebsiteRegistrationForm->isValid()) {
            return redirect()
                ->back()
                ->withErrors($this->visitorWebsiteRegistrationForm->getErrors())
                ->withInput();
        }

        VisitorWebsiteRegistrationService::register($this->request->get('visitor-website-registration'));
        flash()->success('Thank you for registering - see you at the party!');

        return redirect()->back();
    }

    /**
     * @return Factory|View
     */
    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), ['visitorWebsiteRegistrationForm' => $this->visitorWebsiteRegistrationForm]);
    }
}
