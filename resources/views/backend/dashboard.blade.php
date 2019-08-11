@extends('motor-backend::layouts.backend')

@section('htmlheader_title')
    {{ trans('motor-backend::backend.global.home') }}
@endsection

@section('contentheader_title')
    {{ trans('motor-backend::backend/global.dashboard') }}
@endsection

@section('main-content')
    <div class="row">

        @if ($competitionCount !== null)
        <div class="col-sm-3 col-lg-2">
            <div class="card text-white bg-warning">
                <div class="card-body pb-4">
                    <a class="btn btn-transparent p-0 float-right" href="{{ route('backend.competitions.index') }}"><i class="fas fa-link"></i></a>
                    <div class="text-value">{{$competitionCount}}</div>
                    <div>{{trans('partymeister-competitions::backend/competitions.competitions')}}</div>
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-lg-2">
            <div class="card text-white bg-warning">
                <div class="card-body pb-4">
                    <a class="btn btn-transparent p-0 float-right" href="{{ route('backend.entries.index') }}"><i class="fas fa-link"></i></a>
                    <div class="text-value">{{$entryCount}}</div>
                    <div>{{trans('partymeister-competitions::backend/entries.entries')}}</div>
                </div>
            </div>
        </div>
        @endif

        @if ($slideCount !== null)
        <div class="col-sm-3 col-lg-2">
            <div class="card text-white bg-danger">
                <div class="card-body pb-4">
                    <a class="btn btn-transparent p-0 float-right" href="{{ route('backend.slides.index') }}"><i class="fas fa-link"></i></a>
                    <div class="text-value">{{$slideCount}}</div>
                    <div>{{trans('partymeister-slides::backend/slides.slides')}}</div>
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-lg-2">
            <div class="card text-white bg-danger">
                <div class="card-body pb-4">
                    <a class="btn btn-transparent p-0 float-right" href="{{ route('backend.playlists.index') }}"><i class="fas fa-link"></i></a>
                    <div class="text-value">{{$playlistCount}}</div>
                    <div>{{trans('partymeister-slides::backend/playlists.playlists')}}</div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-sm-3 col-lg-2">
            <div class="card text-white bg-info">
                <div class="card-body pb-4">
                    <a class="btn btn-transparent p-0 float-right" href="{{ route('backend.visitors.index') }}"><i class="fas fa-link"></i></a>
                    <div class="text-value">{{$visitorCount}}</div>
                    <div>{{trans('partymeister-core::backend/visitors.visitors')}}</div>
                </div>
            </div>
        </div>

    </div>
    @if ($entryCount > 0)
        <div class="@boxWrapper">
            <div class="@boxHeader">
                <h3 class="box-title">{{trans('partymeister-competitions::backend/entries.latest')}}</h3>
            </div>
            <div class="@boxBody">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{trans('partymeister-competitions::backend/competitions.competition')}}</th>
                        <th>{{trans('partymeister-competitions::backend/entries.title')}}</th>
                        <th>{{trans('partymeister-competitions::backend/entries.author')}}</th>
                        <th class="text-right">{{trans('partymeister-core::backend/global.created_at')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lastEntries as $entry)
                        <tr>
                            <td>{{$entry->competition->name}}</td>
                            <td>{{$entry->title}}</td>
                            <td>{{$entry->author}}</td>
                            <td class="text-right">{{$entry->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($visitorCount > 0)
    <div class="@boxWrapper">
        <div class="@boxHeader">
            <h3 class="box-title">{{trans('partymeister-core::backend/visitors.latest')}}</h3>
        </div>
        <div class="@boxBody">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{{trans('partymeister-core::backend/visitors.name')}} / {{trans('partymeister-core::backend/visitors.group')}}</th>
                    <th class="text-right">{{trans('partymeister-core::backend/global.created_at')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lastVisitors as $visitor)
                    <tr>
                        <td>{{$visitor->name}} @if ($visitor->group != '') / {{$visitor->group}} @endif</td>
                        <td class="text-right">{{$visitor->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if ($playlistCount > 0)
        <div class="@boxWrapper">
            <div class="@boxHeader">
                <h3 class="box-title">{{trans('partymeister-slides::backend/playlists.latest')}}</h3>
            </div>
            <div class="@boxBody">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{trans('partymeister-slides::backend/playlists.name')}}</th>
                        <th>{{trans('partymeister-slides::backend/slides.slides')}}</th>
                        <th class="text-right">{{trans('partymeister-core::backend/global.created_at')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lastPlaylists as $playlist)
                        <tr>
                            <td>{{$playlist->name}}</td>
                            <td>{{$playlist->items->count()}}</td>
                            <td class="text-right">{{$playlist->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    {{--    <partymeister-core-chats :visitors-json="{{$visitors}}" :message-groups-json="'{{$messageGroups}}'"></partymeister-core-chats>--}}
@endsection
