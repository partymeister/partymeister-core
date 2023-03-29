@if (!isset($visitor) || is_null($visitor))
    @foreach (session('flash_notification', collect())->toArray() as $message)
        <div class="callout success">
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
        <div class="grid-x">
            <div class="cell small-12">
                <button type="submit"
                        class="success button expanded">{{ trans('partymeister-core::backend/visitors.request-password') }}</button>
            </div>
        </div>
        {!! form_end($passwordForgottenForm) !!}
    @endif

    @if ($resetType === 'reset')
        <h3>Reset your password</h3>
        {!! form_start($passwordResetForm) !!}
        {!! form_until($passwordResetForm, 'password_confirmation') !!}
        <div class="grid-x">
            <div class="cell small-12">
                <button type="submit"
                        class="success button expanded">{{ trans('partymeister-core::backend/visitors.reset-password') }}</button>
            </div>
        </div>
        {!! form_end($passwordResetForm) !!}
    @endif

@endif
