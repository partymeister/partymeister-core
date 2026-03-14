@if (!isset($visitor) || is_null($visitor))
    <h3 class="mb-4">Registration</h3>
    {!! form_start($visitorRegistrationForm, ['id' => 'category-item']) !!}
    {!! form_until($visitorRegistrationForm, 'submit') !!}
    {!! form_end($visitorRegistrationForm) !!}
@endif
