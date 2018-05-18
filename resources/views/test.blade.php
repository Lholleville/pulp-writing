<html lang="en" >
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Angular Material style sheet -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.8/angular-material.min.css">
</head>
<body ng-app="app" ng-cloak>
<!--
  Your HTML content here
-->


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
        <div class="list-group" ng-repeat="user in users | filter:searchUser">
            <a class="list-group-item text-center" href="{{url('')}}/conversations/<% user.id %>">
                <span class="badge badge-pill badge-danger pull-right" ng-if="user.unread" data-toggle="tooltip" title="<% user.unread %> nouveaux messages" data-placement="top"><% user.unread %></span>
                <img src="<% user.avatar %>" alt="Avatar de <% user.name %>" class="img-extra-mini circled float-left">
                <% user.name %>
                <span ng-if="user.isactive" class="badge badge-pill badge-success pull-right" data-toggle="tooltip" title="En ligne" data-placement="top">.</span>
                <span ng-if="user.activity_offline" class="badge badge-pill badge-secondary pull-right" data-toggle="tooltip" title="<%user.activity_delay%>" data-placement="top">.</span>
            </a>
        </div>
    </div>
</div>


<div ng-controller="MyController as ctrl" layout="column" ng-cloak>
    <md-content class="md-padding">
        <form ng-submit="$event.preventDefault()" name="searchForm">
            <p>The following example demonstrates floating labels being used as a normal form element.</p>
            <div layout-gt-sm="row">
                <md-input-container flex>
                    <label>Name</label>
                    <input type="text"/>
                </md-input-container>
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
                                 md-floating-label="Favorite state">
                    <md-item-template>
                        <span md-highlight-text="ctrl.searchText"><%item.display%></span>
                    </md-item-template>
                    <div ng-messages="searchForm.autocompleteField.$error" ng-if="searchForm.autocompleteField.$touched">
                        <div ng-message="required">You <b>must</b> have a favorite state.</div>
                        <div ng-message="md-require-match">Please select an existing state.</div>
                        <div ng-message="minlength">Your entry is not long enough.</div>
                        <div ng-message="maxlength">Your entry is too long.</div>
                    </div>
                </md-autocomplete>
            </div>
        </form>
    </md-content>
</div>

<!-- Angular Material requires Angular.js Libraries -->
<script src="{{ asset('js/angular.min.js') }}"></script>
<!-- AUTO COMPLETE JS-->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular-animate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular-aria.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.7/angular-messages.min.js"></script>

<!-- AngularJS Material Javascript now available via Google CDN; version 1.1.4 used here -->
<script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.9/angular-material.min.js"></script>
<!-- Your application bootstrap  -->
<script type="text/javascript">
    /**
     * You must include the dependency on 'ngMaterial'
     */
    //angular.module('BlankApp', ['ngMaterial', 'ngMessages']);
    (function () {
        'use strict';
        var app = angular.module('app', ['ngMaterial', 'ngMessages'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        })
            .controller("MyController", MyController);



        function MyController($scope, $timeout, $q) {
            $scope.search = function (item) {
                if ($scope.query == undefined) {
                    return true;
                } else {
                    if (item.name.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ||
                        item.author.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ||
                        item.genre.toLowerCase().indexOf($scope.query.toLowerCase()) != -1) {
                        return true;
                    }
                }
                return false;
            };

            $scope.searchUser = function (item) {
                if ($scope.query == undefined) {
                    return true;
                } else {
                    if (item.name.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ||
                        item.country.toLowerCase().indexOf($scope.query.toLowerCase()) != -1) {
                        return true;
                    }
                }
                return false;
            };

            $scope.searchArticles = function (item) {
                if ($scope.query == undefined) {
                    return true;
                } else {
                    if (item.name.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ||
                        item.author.toLowerCase().indexOf($scope.query.toLowerCase()) != -1) {
                        return true;
                    }
                }
                return false;
            }

            var self = this;

            // list of `state` value/display objects
            self.states        = loadAll();
            self.selectedItem  = null;
            self.searchText    = null;
            self.querySearch   = querySearch;

            // ******************************
            // Internal methods
            // ******************************

            /**
             * Search for states... use $timeout to simulate
             * remote dataservice call.
             */
            function querySearch (query) {
                var results = query ? self.states.filter( createFilterFor(query) ) : self.states;
                var deferred = $q.defer();
                $timeout(function () { deferred.resolve( results ); }, Math.random() * 1000, false);
                return deferred.promise;
            }

            /**
             * Build `states` list of key/value pairs
             */
            function loadAll() {
                var allStates = 'Alabama, Alaska, Arizona, Arkansas, California, Colorado, Connecticut, Delaware,\
              Florida, Georgia, Hawaii, Idaho, Illinois, Indiana, Iowa, Kansas, Kentucky, Louisiana,\
              Maine, Maryland, Massachusetts, Michigan, Minnesota, Mississippi, Missouri, Montana,\
              Nebraska, Nevada, New Hampshire, New Jersey, New Mexico, New York, North Carolina,\
              North Dakota, Ohio, Oklahoma, Oregon, Pennsylvania, Rhode Island, South Carolina,\
              South Dakota, Tennessee, Texas, Utah, Vermont, Virginia, Washington, West Virginia,\
              Wisconsin, Wyoming';

                return allStates.split(/, +/g).map( function (state) {
                    return {
                        value: state.toLowerCase(),
                        display: state
                    };
                });
            }

            /**
             * Create filter function for a query string
             */
            function createFilterFor(query) {
                var lowercaseQuery = angular.lowercase(query);

                return function filterFn(state) {
                    return (state.value.indexOf(lowercaseQuery) === 0);
                };

            }
        };

    })();
</script>

</body>
</html>
