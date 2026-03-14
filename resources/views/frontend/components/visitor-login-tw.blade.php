@if (!isset($visitor) || is_null($visitor))
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Login</h2>
            {!! form_start($visitorLoginForm) !!}
            {!! form_until($visitorLoginForm, 'password') !!}
            <div class="card-actions mt-4">
                <button type="submit" class="btn btn-primary">{{ trans('motor-backend::backend/login.sign_in') }}</button>
                @if (!is_null($component->visitor_registration_page))
                    <a href="{{route('frontend.pages.index', ['slug' => $component->visitor_registration_page->full_slug])}}"
                       class="btn btn-ghost">or register!</a>
                @endif
            </div>
            @if (!is_null($component->password_forgotten_page))
                <div class="mt-2">
                    <a href="{{route('frontend.pages.index', ['slug' => $component->password_forgotten_page->full_slug])}}"
                       class="link link-hover text-sm">Forgot your password?</a>
                </div>
            @endif
            {!! form_end($visitorLoginForm) !!}
        </div>
    </div>
@endif
@if (isset($visitor) && !is_null($visitor))
    <div class="card bg-base-200">
        <div class="card-body">
            <h2 class="card-title">Hello {{$visitor->name}}</h2>
            @if (!is_null($component->entries_page))
                @if ($visitor->new_comments > 0)
                    <div role="alert" class="alert alert-warning alert-vertical sm:alert-horizontal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
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
                <ul class="menu bg-base-100 rounded-box w-full">
                    @if (!is_null($component->entries_page))
                        <li>
                            <a href="{{route('frontend.pages.index', ['slug' => $component->entries_page->full_slug])}}">
                                <i class="fa fa-cloud-upload-alt"></i> My entries
                            </a>
                        </li>
                    @endif
                    @if (config('partymeister-competitions-voting.party_has_voting') && !is_null($component->voting_page))
                        <li>
                            <a href="{{route('frontend.pages.index', ['slug' => $component->voting_page->full_slug])}}">
                                <i class="fa fa-trophy"></i> Vote for the compos
                            </a>
                        </li>
                    @endif
                    @if (!is_null($component->comments_page))
                        <li>
                            <a href="{{route('frontend.pages.index', ['slug' => $component->comments_page->full_slug])}}">
                                <i class="fa fa-comment"></i> Write a message
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="#" x-on:click.prevent="logout()">
                            <i class="fa fa-lock"></i> {{ trans('motor-backend::backend/login.sign_out') }}
                        </a>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endif
