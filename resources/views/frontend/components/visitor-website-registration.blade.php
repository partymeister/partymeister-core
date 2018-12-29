<h4>Register for the party</h4>
@foreach (session('flash_notification', collect())->toArray() as $message)
    <div class="callout success">
        <p>
            {{$message['message']}}
        </p>
    </div>
    {{ session()->forget('flash_notification') }}
@endforeach

{!! form_start($visitorWebsiteRegistrationForm) !!}
<div class="grid-x grid-margin-x">
    <div class="cell small-12 medium-6 large-3">
        {!! form_row($visitorWebsiteRegistrationForm->name) !!}
    </div>
    <div class="cell small-12 medium-6 large-3">
        {!! form_row($visitorWebsiteRegistrationForm->group) !!}
    </div>
    <div class="cell small-12 medium-6 large-3">
        {!! form_row($visitorWebsiteRegistrationForm->country_iso_3166_1) !!}
    </div>
    <div class="cell small-12 medium-6 large-3">
        <label>&nbsp;</label>
        {!! form_row($visitorWebsiteRegistrationForm->submit) !!}
    </div>
</div>
{!! form_end($visitorWebsiteRegistrationForm) !!}