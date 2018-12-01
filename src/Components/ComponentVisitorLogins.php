<?php

namespace Partymeister\Core\Components;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Forms\Component\VisitorLoginForm;
use Partymeister\Core\Services\Component\VisitorLoginService;

class ComponentVisitorLogins
{

    use FormBuilderTrait;

    protected $pageVersionComponent;

    protected $component;

    protected $visitorLoginForm;

    protected $request;


    public function __construct(PageVersionComponent $pageVersionComponent, \Partymeister\Core\Models\Component\ComponentVisitorLogin $component)
    {
        $this->pageVersionComponent = $pageVersionComponent;
        $this->component            = $component;
    }


    public function index(Request $request)
    {
        $this->request = $request;

        $this->visitorLoginForm = $this->form(VisitorLoginForm::class, [
            'name'    => 'visitor-login',
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
        if ($this->request->get('logout') && VisitorLoginService::logout()) {
            $this->request->session()->invalidate();

            return redirect()->back();
        }

        if (is_null($this->request->get('visitor-login'))) {
            return true;
        }

        $data = $this->request->get('visitor-login');

        $this->visitorLoginForm->isValid();
        if ( ! is_null($data)) {
            if (VisitorLoginService::validateLogin($data)) {
                $this->request->session()->regenerate();

                return redirect()->back();
            } else {
                $this->visitorLoginForm->getValidator()->errors()->add('name', 'Something is wrong with your credentials!');

                return redirect()->back()->withErrors($this->visitorLoginForm->getErrors())->withInput();
            }
        }

        return true;
    }


    public function render()
    {
        return view(config('motor-cms-page-components.components.' . $this->pageVersionComponent->component_name . '.view'),
            ['visitorLoginForm' => $this->visitorLoginForm, 'component' => $this->component]);
    }

}
