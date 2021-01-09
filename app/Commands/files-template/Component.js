app.component("{slug}", {
    templateUrl: "./{slug}",
    controller: ["$scope", function($scope) {

        document.title = "{sanitized_title}";

        $scope.strings = window.translations.auth;

    }]
})