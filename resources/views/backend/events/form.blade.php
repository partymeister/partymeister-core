{!! form_start($form) !!}
<div class="@boxWrapper box-primary">
    <div class="@boxHeader with-border">
        <h3 class="box-title">{{ trans('motor-backend::backend/global.base_info') }}</h3>
    </div>
    <div class="@boxBody">
        {!! form_row($form->name) !!}
        {!! form_row($form->schedule_id) !!}
        {!! form_row($form->event_type_id) !!}
        {!! form_row($form->starts_at) !!}
        {!! form_row($form->is_visible) !!}
        {!! form_row($form->is_organizer_only) !!}
        {!! form_row($form->sort_position) !!}
    </div>
    <!-- /.box-body -->

    <div class="@boxFooter">
        {!! form_row($form->submit) !!}
    </div>
</div>
{!! form_end($form) !!}
