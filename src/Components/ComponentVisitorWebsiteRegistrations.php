<?php

namespace Partymeister\Core\Components;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Forms\Component\VisitorWebsiteRegistrationForm;
use Partymeister\Core\Services\Component\VisitorWebsiteRegistrationService;

class ComponentVisitorWebsiteRegistrations {

    use FormBuilderTrait;

    protected $pageVersionComponent;

    protected $visitorWebsiteRegistrationForm;

    protected $request;

    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }

    public function index(Request $request)
    {
        $this->request = $request;

        $this->visitorWebsiteRegistrationForm = $this->form(VisitorWebsiteRegistrationForm::class, [
            'name'    => 'visitor-website-registration',
            'method'  => 'POST',
            'enctype' => 'multipart/form-data'
        ]);

        switch ($request->method()) {
            case 'POST':
                $result = $this->post();
                if ($result instanceOf RedirectResponse) {
                    return $result;
                }
                break;
        }

        return $this->render();
    }


    protected function post()
    {
        if (is_null($this->request->get('visitor-website-registration'))) {
            return true;
        }

        if (!$this->visitorWebsiteRegistrationForm->isValid()) {
            return redirect()->back()->withErrors($this->visitorWebsiteRegistrationForm->getErrors())->withInput();
        }

        VisitorWebsiteRegistrationService::register($this->request->get('visitor-website-registration'));
        flash()->success('Thank you for registering - see you at the party!');

        return redirect()->back();
    }

    public function render()
    {
        return view(config('motor-cms-page-components.components.' . $this->pageVersionComponent->component_name . '.view'),
            ['visitorWebsiteRegistrationForm' => $this->visitorWebsiteRegistrationForm]);
    }

}
