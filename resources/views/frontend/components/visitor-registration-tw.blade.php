@if (!isset($visitor) || is_null($visitor))
    <h3 class="mb-4">Registration</h3>
    @if ($errors->any())
        <div class="rounded-lg border border-error/40 border-l-4 border-l-error bg-error/15 px-4 py-3 text-error mb-4">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! form_start($visitorRegistrationForm, ['id' => 'category-item']) !!}
    {!! form_until($visitorRegistrationForm, 'submit') !!}
    {!! form_end($visitorRegistrationForm) !!}
@endif
