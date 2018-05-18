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
                <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
            </div>
            <input type="text" ng-model="query" class="form-control" placeholder="Vous pouvez chercher le nom d'un texte, le pseudo d'un auteur ou un genre littéraire..."/>
        </div>

        <br>

        <div ng-init="books={{$tabs}}" class="row">
            <div ng-repeat="book in books | filter:search" class="brocoli large-screen">
                <div class="col-md-4 col-sm-6 col-xs-12 library">
                    <div class="flip-container" ontouchstart="this.classList.toggle('hover');">
                        <a href="@{{ book.link }}" id="link">
                            <div class="flipper">
                                <div class="front">
                                    <div class="bandeau" ng-if="book.superliked">
                                        <p class="text-center">Coup de coeur</p>
                                    </div>
                                    <h2 class="title-book text-center">@{{book.name}}</h2>
                                    <h3 class="author-book text-center"><em>@{{book.author}}</em></h3>
                                    <img src="@{{book.avatar}}" alt="avatar de @{{book.name}}" class="img-responsive"/>
                                    <p class="info-general">
                                        <i class="fas fa-eye"></i> @{{book.views}} <i class="fas fa-pencil-alt" aria-hidden="true"></i> @{{book.words}}  <i class="fa fa-book" aria-hidden="true"></i>
                                        @{{book.genre}}
                                    </p>
                                </div>
                                <div class="back">
                                    <p class="info-book">
                                    <h2 class="title-book text-center">@{{book.name}}</h2>
                                    <h3 class="author-book text-center"><em>@{{book.author}}</em></h3>
                                    <br>
                                    <p class="info-book" ng-bind-html-unsafe="book.summary">
                                        @{{book.summary}}
                                        <br>
                                        @{{book.parent}}
                                    </p>
                                    <br>
                                    <p class="info-book">
                                        <i class="fas fa-eye"></i> @{{book.views}} <i class="fas fa-pencil-alt" aria-hidden="true"></i> @{{book.words}}  <i class="fa fa-book" aria-hidden="true"></i></i>
                                        @{{book.genre}}
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

    </div>

@endsection