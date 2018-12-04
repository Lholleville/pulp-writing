@extends('layouts.app')

@section('content')
    <br>
    <div class="col-sm-12">
        <h2><a href="{{route('admin')}}">Retour au panel d'administration principal</a></h2>
    </div>
    <br>
    <div class="col-sm-12" ng-app="app" ng-controller="MyController"  xmlns="http://www.w3.org/1999/html">
        <br>
        <div class="input-group add-on">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
            </div>
            <input type="text" ng-model="query" class="form-control" placeholder="Rechercher..."/>
        </div>
        <br>
        <table class="table table-responsive">
            <tr>
                <th>Avatar</th>
                <th>Nom</th>
                <th>Alias</th>
                <th>Pays</th>
                <th>Editer le Karma et le rôle</th>
            </tr>
        <div ng-init="users={{$users}}" >
            <tr ng-repeat="user in users | filter:searchUser" class="brocoli" >
                <td>
                    <a href="@{{ user.link }}" id="member">
                        <img src="@{{ user.avatar}}" alt="avatar de @{{ user.name }}" class="img-mini" />
                    </a>
                </td>
                <td>
                    <p style="color : <% user.role_color %>;">@{{ user.name }}</p>
                </td>
                <td>
                    <p>@{{ user.alias }}</p>
                </td>
                <td>
                    <p>@{{ user.country }}</p>
                </td>
                <td>
                <form method="POST" action="@{{ user.action }}" accept-charset="UTF-8" class="form-inline">
                    <input name="_method" type="hidden" value="PUT">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input type="text" value="@{{ user.karma }}" class="form-control" name="karma">

                        <select class="form-control" name="role_id" ng-init = "roles={{$roles}}">
                            <option ng-repeat="role in roles" value="@{{ role.id }}" ng-if="role.name == user.role" selected>@{{ role.name }}</option>
                            <option ng-repeat="role in roles" value="@{{ role.id }}" ng-if="role.name != user.role">@{{ role.name }}</option>
                        </select>

                    <button type="submit" class="btn btn-success">save</button>
                </form></td>
            </tr>
        </div>
        </table>
        <div class="no-result">
            <h1 class="text-center">Aucun résultat .... :( </h1>
        </div>

    </div>
@endsection