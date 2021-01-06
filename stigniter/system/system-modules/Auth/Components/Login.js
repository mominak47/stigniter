app.component("login", {
    templateUrl: "./auth/login",
    controller: ["$scope", "$timeout", function($scope, $timeout) {

        document.title = "Momin | Vato ";

        $scope.strings = window.translations.auth;

        $scope.loading = true;

        $scope.user = {};

        $scope.demo = "123";

        $timeout(() => $scope.loading = false, 2000);

    }]
})