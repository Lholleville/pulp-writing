var app = angular.module('app', ['ngMaterial', 'ngMessages', 'ngSanitize'], function($interpolateProvider) {
    // $interpolateProvider.startSymbol('<%');
    // $interpolateProvider.endSymbol('%>');
}).controller("MyController", MyController);

app.config(function($provide){

});

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
        var allStates = $('#users').text();
        allStates = $.trim(allStates);
        allStates = allStates.replace(' ','');
        allStates = allStates.replace('\n','');
        return allStates.split(/,+/g).map( function (state) {
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
