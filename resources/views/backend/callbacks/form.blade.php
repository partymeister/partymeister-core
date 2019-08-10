{!! form_start($form) !!}
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_row($form->name) !!}
        {!! form_row($form->action) !!}
        @if ($form->payload->getValue() != '')
            {!! form_row($form->payload) !!}
        @endif
        {!! form_row($form->destination) !!}
        @if ($form->hash->getValue() != '')
            {!! form_row($form->hash) !!}
        @endif
    </div>
</div>
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('partymeister-core::backend/callbacks.notification_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_row($form->title) !!}
        {!! form_row($form->body) !!}
        {!! form_row($form->link) !!}
    </div>
</div>
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('partymeister-core::backend/callbacks.time_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_row($form->has_fired) !!}
        {!! form_row($form->is_timed) !!}
        {!! form_row($form->embargo_until) !!}
        @if (!is_null($form->fired_at->getValue()))
            {!! form_row($form->fired_at) !!}
        @endif
    </div>
    <div class="@boxFooter">
        {!! form_row($form->submit) !!}
    </div>
</div>
{!! form_end($form, false) !!}
