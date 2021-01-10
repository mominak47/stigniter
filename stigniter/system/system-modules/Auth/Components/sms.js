app.component("sms", {
    templateUrl: "./auth/sms",
    controller: ["$scope", function($scope) {

        document.title = "SMS";

        $scope.strings = window.translations.auth;

    }]
})