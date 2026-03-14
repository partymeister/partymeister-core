<div class="space-y-4">
    <div class="rounded-lg border border-info/40 border-l-4 border-l-info bg-info/15 px-4 py-3 text-info shadow-[0_2px_8px_rgba(0,0,0,0.3)]">
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
                {{$v->name}} @if ($v->group != '') / {{$v->group}} @endif @if ($v->is_remote) <i class="fa {{ $v->remote_type == 'Satellite' ? 'fa-satellite-dish' : 'fa-laptop-house' }}" title="{{ $v->remote_type }}"></i> @endif
            </div>
        @endforeach
    </div>
</div>
