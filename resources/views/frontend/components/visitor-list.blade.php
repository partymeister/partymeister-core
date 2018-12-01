<div class="callout primary">
    <p>
        {{$visitors->count()}} people are registered in the party network!
    </p>
</div>

<div class="grid-x">
    @foreach ($visitors as $v)
        <div class="cell medium-6 small-12">
            <span class="flag-icon flag-icon-{{strtolower($v->country_iso_3166_1)}}"></span>
            {{$v->name}} @if ($v->group != '') / {{$v->group}} @endif
        </div>
    @endforeach
</div>
