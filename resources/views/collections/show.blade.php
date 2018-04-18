@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>{{$collection->name}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <img src="{{url($collection->avatar)}}" alt="image de la collection" class="img-collec">
                <hr>
                <p class="text-justify">{{ $collection->description }}</p>
                <hr>
            </div>
        </div>
    </div>
    <div class="container" ng-app="app" ng-controller="MyController" xmlns="http://www.w3.org/1999/html">
        <div class="input-group add-on">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
            <input type="text" ng-model="query" class="form-control" placeholder="Vous pouvez chercher le nom d'un texte, le pseudo d'un auteur ou un genre littéraire..."/>
        </div>

        <br>

        <div ng-init="books={{$tabs}}" class="row">
            <div ng-repeat="book in books | filter:search" class="brocoli large-screen">
                <div class="col-md-4 col-sm-6 col-xs-12 library">
                    <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                        <a href="{{url('<% book.collection_slug %>/<% book.slug %>')}}" id="link">
                            <div class="flipper">
                                <div class="front">
                                    <h2 class="title-book text-center"><% book.name %></h2>
                                    <h3 class="author-book text-center"><em><% book.author %></em></h3>
                                    <img src="{{url('<% book.avatar %>')}}" alt="" class="img-responsive"/>
                                    <p class="info-general">
                                        <span class="glyphicon glyphicon-eye-open"></span> <% book.views %> <i class="fa fa-pencil" aria-hidden="true"></i> <% book.words %>  <i class="fa fa-book" aria-hidden="true"></i>
                                        <% book.genre %>
                                    </p>
                                </div>
                                <div class="back">
                                    <p class="info-book">
                                    <h2 class="title-book text-center"><% book.name %></h2>
                                    <h3 class="author-book text-center"><em><% book.author %></em></h3>
                                    <br>
                                    <p class="info-book" ng-bind-html-unsafe="book.summary">
                                        <% book.summary %>
                                        <br>
                                        <% book.parent %>
                                    </p>
                                    <br>
                                    <p class="info-book">
                                        <span class="glyphicon glyphicon-eye-open"></span> <% book.views %> <i class="fa fa-pencil" aria-hidden="true"></i> <% book.words %>  <i class="fa fa-book" aria-hidden="true"></i></i>
                                        <% book.genre %>
                                    </p>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="no-result">
                <h1 class="text-center">Aucun résultat .... :( </h1>
            </div>
        </div>

        <div ng-init="books={{$tabs}}" class="row">
            <div ng-repeat="book in books | filter:search" class="brocoli small-screen">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="background-pomegranate">
                        <h2 class="text-center title-book"><% book.name %></h2>
                        <h3 class="text-center author-book"><em><% book.author %></em></h3>
                    </div>
                    <a href="{{url('read/<% book.id %>')}}" id="link">
                        <img src="{{url('<% book.avatar %>')}}" alt="" class="img-responsive" />
                    </a>
                    <p class="info-general">
                        <span class="glyphicon glyphicon-eye-open"></span> <% book.views %> <i class="fa fa-pencil" aria-hidden="true"></i> <% book.words %>  <i class="fa fa-book" aria-hidden="true"></i> <% book.genre %> {{--<span data-toggle="tooltip" title="<% book.summary %><br><br> <% book.parent %>" data-placement="bottom"><i class="fa fa-info-circle"></i> résumé</span>--}}
                    </p>
                    <br>
                </div>
            </div>
            <div class="no-result">
                <h1 class="text-center">Aucun résultat .... :( </h1>
            </div>
        </div>
    </div>

@endsection