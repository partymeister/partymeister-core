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

    protected $visitorLoginForm;

    protected $request;

    /**
     * ComponentVisitorLogins constructor.
     */
    public function __construct(
        PageVersionComponent $pageVersionComponent,
        ComponentVisitorLogin $component
    ) {
        $this->pageVersionComponent = $pageVersionComponent;
        $this->component = $component;
    }

    /**
     * @return bool|Factory|RedirectResponse|View
     */
    public function index(Request $request)
    {
        $this->request = $request;

        $this->visitorLoginForm = $this->form(VisitorLoginForm::class, [
            'name' => 'visitor-login',
            'method' => 'POST',
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
        if ($this->request->get('logout') && VisitorLoginService::logout()) {
            $this->request->session()
                ->invalidate();

            return redirect()->back();
        }

        if (is_null($this->request->get('visitor-login'))) {
            return true;
        }

        if (! $this->visitorLoginForm->isValid()) {
            return redirect()
                ->back()
                ->withErrors($this->visitorLoginForm->getErrors())
                ->withInput();
        }
        $this->request->session()
            ->regenerate();

        return redirect()->back();
    }

    /**
     * @return Factory|View
     */
    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), [
            'visitorLoginForm' => $this->visitorLoginForm,
            'component' => $this->component,
        ]);
    }
}
