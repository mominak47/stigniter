const app = angular.module("myApp", ["ngRoute"]);

app.run(['$http', function ($http) {
    $http.defaults.headers.common['STIGNITER-AJAX'] = 'AJAX-CONTENT-REQUESTED';
}]);