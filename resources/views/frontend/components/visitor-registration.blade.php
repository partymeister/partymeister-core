@if (!isset($visitor) || is_null($visitor))
    <h4>Registration</h4>
    {!! form_start($visitorRegistrationForm, ['id' => 'category-item']) !!}
    {!! form_until($visitorRegistrationForm, 'submit') !!}
    {!! form_end($visitorRegistrationForm) !!}
@endif