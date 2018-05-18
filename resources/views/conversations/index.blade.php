@extends('layouts.app')

@section('content')
    <div class="row" ng-app="app">

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
        <div id="users" style="display: none">
            <?php foreach($users as $user){
                echo $user->name.",";
            }
            ?>
        </div>
        <div class="col-sm-4"  ng-controller="MyController" xmlns="http://www.w3.org/1999/html">
            <div class="input-group add-on">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                </div>
                <input type="text" ng-model="query" class="form-control" placeholder="Chercher un membre..."/>
            </div>
            <br>
            <div ng-init="users={{$tabs}}">
                <div class="list-group">
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
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <div ng-controller="MyController as ctrl" layout="column" ng-cloak>
                        <md-content class="md-padding">
                            <form action="" method="POST" name="searchForm">
                                {{ csrf_field() }}
                                <div layout-gt-sm="row">
                                    <md-autocomplete flex required
                                                     md-input-name="autocompleteField"
                                                     md-input-minlength="2"
                                                     md-input-maxlength="18"
                                                     md-no-cache="ctrl.noCache"
                                                     md-selected-item="ctrl.selectedItem"
                                                     md-search-text="ctrl.searchText"
                                                     md-items="item in ctrl.querySearch(ctrl.searchText)"
                                                     md-item-text="item.display"
                                                     md-require-match
                                                     md-floating-label="Destinataire">
                                        <md-item-template>
                                            <span md-highlight-text="ctrl.searchText" id="bind-html-with-trust">@{{ item.display }}</span>
                                        </md-item-template>
                                        <div ng-messages="searchForm.autocompleteField.$error" ng-if="searchForm.autocompleteField.$touched">
                                            <div ng-message="required">Vous devez indiquer un utilisateur.</div>
                                            <div ng-message="md-require-match">Vous devez indiquer un utilisateur existant.</div>
                                            <div ng-message="minlength">Votre saisie n'est pas assez longue.</div>
                                            <div ng-message="maxlength">Votre saisie est trop longue.</div>
                                        </div>
                                    </md-autocomplete>
                                </div>
                                <div class="form-group">
                                    <textarea name="content" id="" class="form-control" placeholder="Ecrivez votre message"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Envoyer</button>
                                </div>
                            </form>
                        </md-content>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection