app.component("login", {
    templateUrl: "./auth/login",
    controller: ["$scope", function($scope) {

        document.title = "Login";
        $scope.strings = window.translations.auth;


        $scope.user = {};

    }]
})