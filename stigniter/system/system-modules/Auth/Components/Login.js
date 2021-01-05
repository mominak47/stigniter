app.component("login", {
    templateUrl: "./auth/login",
    controller: ["$scope", "$timeout", function($scope, $timeout) {

        document.title = "Login | Vato ";
        $scope.strings = window.translations.auth;

        $scope.loading = true;

        $scope.user = {};

        $timeout(() => $scope.loading = false, 2000);


    }]
})