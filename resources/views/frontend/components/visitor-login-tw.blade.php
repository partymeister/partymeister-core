@if (!isset($visitor) || is_null($visitor))
    <div class="rounded-lg bg-surface border border-border shadow-[0_4px_12px_rgba(0,0,0,0.4)]">
        <div class="p-5">
            <h3 class="mb-3">Login</h3>
            {!! form_start($visitorLoginForm) !!}
            {!! form_until($visitorLoginForm, 'password') !!}
            <div class="mt-4 flex gap-2">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-accent px-5 py-2 font-medium text-body hover:bg-accent-hover shadow-[0_2px_4px_rgba(224,192,89,0.2)] transition-colors">{{ trans('motor-backend::backend/login.sign_in') }}</button>
                @if (!is_null($component->visitor_registration_page))
                    <a href="{{route('frontend.pages.index', ['slug' => $component->visitor_registration_page->full_slug])}}"
                       class="inline-flex items-center justify-center rounded-lg px-5 py-2 font-medium text-text hover:text-heading hover:bg-surface-raised transition-colors">or register!</a>
                @endif
            </div>
            @if (!is_null($component->password_forgotten_page))
                <div class="mt-2">
                    <a href="{{route('frontend.pages.index', ['slug' => $component->password_forgotten_page->full_slug])}}"
                       class="text-accent hover:text-accent-hover underline transition-colors text-sm">Forgot your password?</a>
                </div>
            @endif
            {!! form_end($visitorLoginForm) !!}
        </div>
    </div>
@endif
@if (isset($visitor) && !is_null($visitor))
    <div class="rounded-lg bg-surface border border-border shadow-[0_4px_12px_rgba(0,0,0,0.4)]">
        <div class="p-5">
            <h3 class="mb-3">Hello {{$visitor->name}}</h3>
            @if (!is_null($component->entries_page))
                @if ($visitor->new_comments > 0)
                    <div role="alert" class="rounded-lg border border-accent/40 border-l-4 border-l-accent bg-accent/15 px-4 py-3 text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current inline-block mr-2" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <a href="{{route('frontend.pages.index', ['slug' => $component->entries_page->full_slug])}}">
                            You have {{$visitor->new_comments}} new
                            @if ($visitor->new_comments > 1) messages @else message @endif
                            for your entries!
                        </a>
                    </div>
                @endif
            @endif
            <form id="logout" method="POST" x-data="visitorLogin">
                {{ csrf_field() }}
                <input type="hidden" name="logout" value="1">
                <ul class="space-y-1 w-full">
                    @if (!is_null($component->entries_page))
                        <li>
                            <a href="{{route('frontend.pages.index', ['slug' => $component->entries_page->full_slug])}}"
                               class="block rounded-lg px-3 py-2 text-text hover:text-heading hover:bg-surface-raised transition-colors">
                                <svg class="inline-block w-4 h-4 mr-1.5 -mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/>
                                </svg> My entries
                            </a>
                        </li>
                    @endif
                    @if (config('partymeister-competitions-voting.party_has_voting') && !is_null($component->voting_page))
                        <li>
                            <a href="{{route('frontend.pages.index', ['slug' => $component->voting_page->full_slug])}}"
                               class="block rounded-lg px-3 py-2 text-text hover:text-heading hover:bg-surface-raised transition-colors">
                                <svg class="inline-block w-4 h-4 mr-1.5 -mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg> Vote for the compos
                            </a>
                        </li>
                    @endif
                    @if (!is_null($component->comments_page))
                        <li>
                            <a href="{{route('frontend.pages.index', ['slug' => $component->comments_page->full_slug])}}"
                               class="block rounded-lg px-3 py-2 text-text hover:text-heading hover:bg-surface-raised transition-colors">
                                <svg class="inline-block w-4 h-4 mr-1.5 -mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg> Write a message
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="#" x-on:click.prevent="logout()"
                           class="block rounded-lg px-3 py-2 text-text hover:text-heading hover:bg-surface-raised transition-colors">
                            <svg class="inline-block w-4 h-4 mr-1.5 -mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>
                            </svg> {{ trans('motor-backend::backend/login.sign_out') }}
                        </a>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endif
