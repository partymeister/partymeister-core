{!! form_start($form) !!}
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_row($form->category_id) !!}
        {!! form_row($form->name) !!}
        {!! form_row($form->handle) !!}
        {!! form_row($form->company) !!}
        {!! form_row($form->email) !!}
        {!! form_row($form->country) !!}
        {!! form_row($form->ticket_code) !!}
        {!! form_row($form->ticket_type) !!}
        {!! form_row($form->ticket_order_number) !!}
        {!! form_row($form->comment) !!}
        {!! form_row($form->has_badge) !!}
        {!! form_row($form->has_arrived) !!}
        {!! form_row($form->ticket_code_scanned) !!}
        @if (!is_null($form->arrived_at->getValue()))
            {!! form_row($form->arrived_at) !!}
        @endif
    </div>
    <!-- /.box-body -->

    <div class="@boxFooter">
        {!! form_row($form->submit) !!}
    </div>
</div>
{!! form_end($form, false) !!}
