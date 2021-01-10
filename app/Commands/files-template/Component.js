app.component("{component_name}", {
    templateUrl: "./{path}",
    controller: ["$scope", function($scope) {

        document.title = "{sanitized_title}";

        $scope.strings = window.translations.auth;

    }]
})