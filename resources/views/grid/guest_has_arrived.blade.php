<button type="button" data-toggle="tooltip" data-placement="top" data-record="{{$record->id}}" data-class="btn-success"
        data-class-alternate="btn-outline-secondary" data-has-arrived="{{(int)!$record->has_arrived}}"
        class="change-has-arrived btn @defaultButtonSize @if ($record->has_arrived == 1)btn-success @else btn-outline-secondary @endif"
        title="{{trans('partymeister-core::backend/guests.has_arrived')}}">{{trans('partymeister-core::backend/guests.has_arrived')}}</button>
