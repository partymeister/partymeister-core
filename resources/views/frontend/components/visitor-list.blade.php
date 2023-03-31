<div class="callout primary">
    <p>
        @if ($visitors->count() == 1)
            One person is registered! Woohoo!
        @else
            {{$visitors->count()}} people are registered!
        @endif
    </p>
</div>

<div class="grid-x">
    @foreach ($visitors as $v)
        <div class="cell medium-6 small-12">
            <span class="flag-icon flag-icon-{{strtolower($v->country_iso_3166_1)}}"></span>
            {{$v->name}} @if ($v->group != '') / {{$v->group}} @endif @if ($v->is_remote) <i class="fa {{ $v->remote_type == 'Satellite' ? 'fa-satellite-dish' : 'fa-laptop-house' }}" title="{{ $v->remote_type }}"></i> @endif
        </div>
    @endforeach
</div>
