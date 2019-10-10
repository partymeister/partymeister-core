<?php

namespace Partymeister\Core\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Forms\Component\VisitorLoginForm;
use Partymeister\Core\Models\Component\ComponentVisitorLogin;
use Partymeister\Core\Services\Component\VisitorLoginService;

/**
 * Class ComponentVisitorLogins
 * @package Partymeister\Core\Components
 */
class ComponentVisitorLogins
{
    use FormBuilderTrait;

    /**
     * @var PageVersionComponent
     */
    protected $pageVersionComponent;

    /**
     * @var ComponentVisitorLogin
     */
    protected $component;

    /**
     * @var
     */
    protected $visitorLoginForm;

    /**
     * @var
     */
    protected $request;


    /**
     * ComponentVisitorLogins constructor.
     * @param PageVersionComponent  $pageVersionComponent
     * @param ComponentVisitorLogin $component
     */
    public function __construct(
        PageVersionComponent $pageVersionComponent,
        ComponentVisitorLogin $component
    ) {
        $this->pageVersionComponent = $pageVersionComponent;
        $this->component            = $component;
    }


    /**
     * @param Request $request
     * @return bool|Factory|RedirectResponse|View
     */
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
        if ($this->request->get('logout') && VisitorLoginService::logout()) {
            $this->request->session()->invalidate();

            return redirect()->back();
        }

        if (is_null($this->request->get('visitor-login'))) {
            return true;
        }

        $data = $this->request->get('visitor-login');

        $this->visitorLoginForm->isValid();
        if (! is_null($data)) {
            if (VisitorLoginService::validateLogin($data)) {
                $this->request->session()->regenerate();

                return redirect()->back();
            } else {
                $this->visitorLoginForm->getValidator()
                                       ->errors()
                                       ->add('name', 'Something is wrong with your credentials!');

                return redirect()->back()->withErrors($this->visitorLoginForm->getErrors())->withInput();
            }
        }

        return true;
    }


    /**
     * @return Factory|View
     */
    public function render()
    {
        return view(
            config('motor-cms-page-components.components.' . $this->pageVersionComponent->component_name . '.view'),
            [ 'visitorLoginForm' => $this->visitorLoginForm, 'component' => $this->component ]
        );
    }
}
