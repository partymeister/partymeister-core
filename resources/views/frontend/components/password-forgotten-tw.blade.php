@if (!isset($visitor) || is_null($visitor))
    @foreach (session('flash_notification', collect())->toArray() as $message)
        <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success">
            <p>
                {{$message['message']}}
            </p>
        </div>
        {{ session()->forget('flash_notification') }}
    @endforeach

    @if ($resetType === 'forgotten')
        <h3>Password forgotten?</h3>
        {!! form_start($passwordForgottenForm) !!}
        {!! form_until($passwordForgottenForm, 'email') !!}
        <div class="flex flex-wrap">
            <div class="w-full">
                <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-success px-5 py-2.5 text-sm font-semibold text-body hover:bg-success/90 transition-colors">{{ trans('partymeister-core::backend/visitors.request-password') }}</button>
            </div>
        </div>
        {!! form_end($passwordForgottenForm) !!}
    @endif

    @if ($resetType === 'reset')
        <h3>Reset your password</h3>
        {!! form_start($passwordResetForm) !!}
        {!! form_until($passwordResetForm, 'password_confirmation') !!}
        <div class="flex flex-wrap">
            <div class="w-full">
                <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-lg bg-success px-5 py-2.5 text-sm font-semibold text-body hover:bg-success/90 transition-colors">{{ trans('partymeister-core::backend/visitors.reset-password') }}</button>
            </div>
        </div>
        {!! form_end($passwordResetForm) !!}
    @endif

@endif
