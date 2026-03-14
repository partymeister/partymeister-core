@if (!isset($visitor) || is_null($visitor))
    <div class="rounded-lg bg-surface shadow-[0_2px_8px_rgba(0,0,0,0.3)]">
        <div class="p-5">
            <h2 class="text-heading font-semibold text-lg mb-3">Login</h2>
            {!! form_start($visitorLoginForm) !!}
            {!! form_until($visitorLoginForm, 'password') !!}
            <div class="mt-4 flex gap-2">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-accent px-5 py-2 text-sm font-semibold text-body hover:bg-accent-hover shadow-[0_2px_4px_rgba(224,192,89,0.2)] transition-colors">{{ trans('motor-backend::backend/login.sign_in') }}</button>
                @if (!is_null($component->visitor_registration_page))
                    <a href="{{route('frontend.pages.index', ['slug' => $component->visitor_registration_page->full_slug])}}"
                       class="inline-flex items-center justify-center rounded-lg px-5 py-2 text-sm font-medium text-text hover:text-heading hover:bg-surface-raised transition-colors">or register!</a>
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
    <div class="rounded-lg bg-surface shadow-[0_2px_8px_rgba(0,0,0,0.3)]">
        <div class="p-5">
            <h2 class="text-heading font-semibold text-lg mb-3">Hello {{$visitor->name}}</h2>
            @if (!is_null($component->entries_page))
                @if ($visitor->new_comments > 0)
                    <div role="alert" class="rounded-lg border border-accent/30 bg-accent/10 px-4 py-3 text-sm text-accent">
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
                               class="block rounded-lg px-3 py-2 text-sm text-text hover:text-heading hover:bg-surface-raised transition-colors">
                                <i class="fa fa-cloud-upload-alt"></i> My entries
                            </a>
                        </li>
                    @endif
                    @if (config('partymeister-competitions-voting.party_has_voting') && !is_null($component->voting_page))
                        <li>
                            <a href="{{route('frontend.pages.index', ['slug' => $component->voting_page->full_slug])}}"
                               class="block rounded-lg px-3 py-2 text-sm text-text hover:text-heading hover:bg-surface-raised transition-colors">
                                <i class="fa fa-trophy"></i> Vote for the compos
                            </a>
                        </li>
                    @endif
                    @if (!is_null($component->comments_page))
                        <li>
                            <a href="{{route('frontend.pages.index', ['slug' => $component->comments_page->full_slug])}}"
                               class="block rounded-lg px-3 py-2 text-sm text-text hover:text-heading hover:bg-surface-raised transition-colors">
                                <i class="fa fa-comment"></i> Write a message
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="#" x-on:click.prevent="logout()"
                           class="block rounded-lg px-3 py-2 text-sm text-text hover:text-heading hover:bg-surface-raised transition-colors">
                            <i class="fa fa-lock"></i> {{ trans('motor-backend::backend/login.sign_out') }}
                        </a>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endif
