<?php

namespace Partymeister\Core\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Models\PasswordReset;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Core\Forms\Component\PasswordForgottenForm;
use Partymeister\Core\Forms\Component\PasswordResetForm;
use Partymeister\Core\Models\Visitor;

/**
 * Class ComponentVisitorLists
 */
class ComponentPasswordForgotten
{
    use FormBuilderTrait;

    /**
     * @var PageVersionComponent
     */
    protected $pageVersionComponent;

    /**
     * @var
     */
    protected $passwordForgottenForm;

    /**
     * @var
     */
    protected $passwordResetForm;

    protected $resetType = 'forgotten';

    /**
     * @var
     */
    protected $request;

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
     * @return bool|Factory|RedirectResponse|View
     */
    public function index(Request $request)
    {
        $this->request = $request;

        if ($this->request->get('t') !== null && $reset = PasswordReset::where('token', $this->request->get('t'))
                                                                       ->first() !== null) {
            $this->resetType = 'reset';
            $this->passwordResetForm = $this->form(PasswordResetForm::class, [
                'name'    => 'password-reset',
                'method'  => 'POST',
                'url'     => url('/password-forgotten?t='.$this->request->get('t')),
                'enctype' => 'multipart/form-data',
            ]);
        } else {
            $this->passwordForgottenForm = $this->form(PasswordForgottenForm::class, [
                'name'    => 'password-forgotten',
                'method'  => 'POST',
                'enctype' => 'multipart/form-data',
            ]);
        }

        switch ($request->method()) {
            case 'POST':
                if ($this->resetType === 'forgotten') {
                    $result = $this->postForgotten();
                    if ($result instanceof RedirectResponse) {
                        return $result;
                    }
                }
                if ($this->resetType === 'reset') {
                    $result = $this->postReset();
                    if ($result instanceof RedirectResponse) {
                        return $result;
                    }
                }
                break;
        }

        return $this->render();
    }

    /**
     * @return bool|RedirectResponse
     */
    protected function postReset()
    {
        if (is_null($this->request->get('password-reset'))) {
            return true;
        }

        if (! $this->passwordResetForm->isValid()) {

            return redirect()
                ->back()
                ->withErrors($this->passwordResetForm->getErrors())
                ->withInput();
        }

        // Remove old tokens with the same email address
        $passwordReset = PasswordReset::where('token', $this->request->get('t'))
                                      ->first();

        $visitor = Visitor::where('email', $passwordReset->email)
                          ->first();

        if (! is_null($visitor)) {
            $visitor->password = bcrypt(Arr::get($this->request, 'password-reset.password'));
            $visitor->save();
        }

        // Remove old tokens with the same email address
        PasswordReset::where('email', $visitor->email)
                     ->delete();

        flash()->success('Your password has been changed. Have fun logging in!');

        return redirect('/');
    }

    /**
     * @return bool|RedirectResponse
     */
    protected function postForgotten()
    {
        if (is_null($this->request->get('password-forgotten'))) {
            return true;
        }

        if (! $this->passwordForgottenForm->isValid()) {

            return redirect()
                ->back()
                ->withErrors($this->passwordForgottenForm->getErrors())
                ->withInput();
        }

        $email = Arr::get($this->request, 'password-forgotten.email');

        // Remove old tokens with the same email address
        PasswordReset::where('email', $email)
                     ->delete();

        // Save link in DB, send email
        $reset = PasswordReset::create([
            'email'      => Arr::get($this->request, 'password-forgotten.email'),
            'token'      => Str::uuid(),
            'created_at' => Carbon::now(),
        ]);

        Mail::to($email)
            ->send(new \Partymeister\Core\Mail\PasswordReset($reset->token));

        flash()->success('A password reset email has been sent - please also check your spam folder!');

        return redirect()->back();
    }

    /**
     * @return Factory|View
     */
    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), [
            'passwordForgottenForm' => $this->passwordForgottenForm,
            'passwordResetForm'     => $this->passwordResetForm,
            'resetType'             => $this->resetType,
        ]);
    }
}
