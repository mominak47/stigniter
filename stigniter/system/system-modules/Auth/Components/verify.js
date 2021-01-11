app.component("verify", {
    template: `
        <h1>It is a verification component</h1>
    `,
    controller: ["$scope", function($scope) {
        $scope.strings = window.translations.auth;
    }]
})