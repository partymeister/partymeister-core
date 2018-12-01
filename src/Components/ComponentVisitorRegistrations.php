<?php

namespace Partymeister\Core\Components;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Forms\Component\VisitorRegistrationForm;
use Partymeister\Core\Services\Component\VisitorRegistrationService;

class ComponentVisitorRegistrations
{

    use FormBuilderTrait;

    protected $pageVersionComponent;

    protected $visitorRegistrationForm;

    protected $request;


    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }


    public function index(Request $request)
    {
        $this->request = $request;

        $this->visitorRegistrationForm = $this->form(VisitorRegistrationForm::class, [
            'name'    => 'visitor-registration',
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
        if (is_null($this->request->get('visitor-registration'))) {
            return true;
        }

        if (!$this->visitorRegistrationForm->isValid()) {
            return redirect()->back()->withErrors($this->visitorRegistrationForm->getErrors())->withInput();
        }
        VisitorRegistrationService::register($this->request->get('visitor-registration'));
        return redirect()->back();
    }

    public function render()
    {
        return view(config('motor-cms-page-components.components.' . $this->pageVersionComponent->component_name . '.view'),
            ['visitorRegistrationForm' => $this->visitorRegistrationForm]);
    }

}
