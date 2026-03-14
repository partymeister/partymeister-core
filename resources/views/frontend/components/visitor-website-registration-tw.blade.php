<h3>Register for the party</h3>
@foreach (session('flash_notification', collect())->toArray() as $message)
    <div class="rounded-lg border border-success/40 border-l-4 border-l-success bg-success/15 px-4 py-3 text-success">
        <p>
            {{$message['message']}}
        </p>
    </div>
    {{ session()->forget('flash_notification') }}
@endforeach

{!! form_start($visitorWebsiteRegistrationForm) !!}
<div class="flex flex-wrap gap-4">
    <div class="w-full md:w-3/12 lg:w-3/12">
        {!! form_row($visitorWebsiteRegistrationForm->name) !!}
    </div>
    <div class="w-full md:w-3/12 lg:w-3/12">
        {!! form_row($visitorWebsiteRegistrationForm->group) !!}
    </div>
    <div class="w-full md:w-3/12 lg:w-3/12">
        {!! form_row($visitorWebsiteRegistrationForm->country_iso_3166_1) !!}
    </div>
    <div class="w-full md:w-3/12 lg:w-3/12">
        <label>&nbsp;</label>
        {!! form_row($visitorWebsiteRegistrationForm->submit) !!}
    </div>
</div>
{!! form_end($visitorWebsiteRegistrationForm) !!}
