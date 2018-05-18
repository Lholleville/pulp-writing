
<?php
        foreach($users as $user){
            $tab['id'] = $user->id;
            $tab['name'] = $user->name;
            if(isset($unread[$user->id])){
                $tab['unread'] = $unread[$user->id];
            }else{
                $tab['unread'] = false;
            }
            $tab['avatar'] = url($user->avatar);
            $tab['isactive'] = $user->isActive();
            $tab['activity_offline'] = !$user->activity[0];
            $tab['activity_delay'] = $user->activity[1];
            $tab['country'] = $user->country;
            $tabs[] = $tab;
        }

        $tabs = json_encode($tabs);
?>

<div class="col-sm-4" ng-app="app" ng-controller="MyController" xmlns="http://www.w3.org/1999/html">
    <div class="input-group add-on">
        <div class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
        </div>
        <input type="text" ng-model="query" class="form-control" placeholder="Chercher un membre..."/>
    </div>
<br>
    <div ng-init="users={{$tabs}}">
        <div class="list-group">
            <a href="{{ route('messagerie') }}" class="list-group-item text-center" >
                <img src="{{ url('img/icon/new_message.png') }}" alt="Icône nouveau message" class="img-extra-mini circled float-left">
                Nouveau message
            </a>
            <a ng-repeat="user in users | filter:searchUser" class="list-group-item text-center" href="{{url('')}}/conversations/@{{ user.id }}">
                <span class="badge badge-pill badge-danger pull-right" ng-if="user.unread" data-toggle="tooltip" title="@{{ user.unread }} nouveaux messages" data-placement="top">@{{ user.unread }}</span>
                <img src="@{{ user.avatar }}" alt="Avatar de @{{ user.name }}" class="img-extra-mini circled float-left">
                @{{ user.name }}
                <span ng-if="user.isactive" class="badge badge-pill badge-success pull-right" data-toggle="tooltip" title="En ligne" data-placement="top">.</span>
                <span ng-if="user.activity_offline" class="badge badge-pill badge-secondary pull-right" data-toggle="tooltip" title="@{{user.activity_delay}}" data-placement="top">.</span>
            </a>
        </div>
    </div>
</div>


{{--<div class="col-sm-4">--}}
    {{--<div class="list-group">--}}
        {{--@foreach($users as $user)--}}
            {{--<a class="list-group-item text-center" href="{{ route('messagerie.show', $user->id) }}">--}}
                {{--@if(isset($unread[$user->id]))--}}
                    {{--<span class="badge badge-pill badge-danger pull-right">--}}
                            {{--{{ $unread[$user->id] }}--}}
                        {{--</span>--}}
                {{--@endif--}}
                {{--<img src="{{ url($user->avatar) }}" alt="Avatar de {{ $user->name }}" class="img-extra-mini circled float-left">--}}
                {{--{{ $user->name }}  --}}
                {{--@if($user->isActive())--}}
                    {{--<span class="badge badge-pill badge-success pull-right" data-toggle="tooltip" title="En ligne" data-placement="top">.</span>--}}
                {{--@endif--}}
                {{--@if(!$user->activity[0])--}}
                    {{--<span class="badge badge-pill badge-secondary pull-right" data-toggle="tooltip" title="{{ $user->activity[1] }}" data-placement="top">.</span>--}}
                {{--@endif--}}
            {{--</a>--}}
        {{--@endforeach--}}
    {{--</div>--}}
{{--</div>--}}
