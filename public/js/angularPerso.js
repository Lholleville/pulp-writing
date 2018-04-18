var app = angular.module('app', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}).controller("MyController", function($scope){
    $scope.search = function(item){
        if($scope.query == undefined){
            return true;
        }else{
            if(item.name.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ||
                item.author.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ||
                item.genre.toLowerCase().indexOf($scope.query.toLowerCase()) != -1){
                return true;
            }
        }
        return false;
    };

    $scope.searchUser = function(item){
        if($scope.query == undefined){
            return true;
        }else{
            if(item.name.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ||
                item.country.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ){
                return true;
            }
        }
        return false;
    };

    $scope.searchArticles = function(item){
        if($scope.query == undefined){
            return true;
        }else{
            if(item.name.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ||
                item.author.toLowerCase().indexOf($scope.query.toLowerCase()) != -1 ){
                return true;
            }
        }
        return false;
    }

});