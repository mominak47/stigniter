const app = angular.module("myApp", ["ngRoute"]);


app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        template : "<login/>"
    })
});