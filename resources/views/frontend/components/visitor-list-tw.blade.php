<div class="space-y-4">
    {{-- SVG symbol definitions (rendered once, referenced via <use>) --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="hidden">
        <symbol id="icon-satellite" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <title>Satellite</title>
            <path d="M13 7 9 3 5 7l4 4"/><path d="m17 11 4 4-4 4-4-4"/><path d="m8 12 4 4 6-6-4-4Z"/><path d="m16 8 3-3"/><path d="M9 21a6 6 0 0 0-6-6"/>
        </symbol>
        <symbol id="icon-remote" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <title>Remote</title>
            <rect width="18" height="12" x="3" y="4" rx="2" ry="2"/><line x1="2" x2="22" y1="20" y2="20"/>
        </symbol>
    </svg>

    <div class="rounded-lg border border-info/40 border-l-4 border-l-info bg-info/15 px-4 py-3 text-info">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current inline-block mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>
            @if ($visitors->count() == 1)
                One person is registered! Woohoo!
            @else
                {{$visitors->count()}} people are registered!
            @endif
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
        @foreach ($visitors as $v)
            <div class="py-1">
                <span class="fi fi-{{strtolower($v->country_iso_3166_1)}}"></span>
                {{$v->name}} @if ($v->group != '') / {{$v->group}} @endif @if ($v->is_remote) <svg class="inline-block w-5 h-5 ml-1 -mt-0.5 text-white" role="img" aria-label="{{ $v->remote_type }}"><title>{{ $v->remote_type }}</title><rect width="24" height="24" fill="transparent"/><use href="#icon-{{ $v->remote_type == 'Satellite' ? 'satellite' : 'remote' }}"/></svg>@endif
            </div>
        @endforeach
    </div>
</div>
