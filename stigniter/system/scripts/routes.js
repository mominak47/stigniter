
app.config(function($routeProvider) {
  $routeProvider
    .when("/login", {
    template : "<login/>"
  })
    .when("/auth/login", {
    template : "<login/>"
  })
    .when("/", {
    template : "<login/>"
  })
    .when("/register", {
    template : "<register/>"
  })
    .when("/auth/register", {
    template : "<register/>"
  })
    .when("/auth/password", {
    template : "<password-reset/>"
  })
    .when("/auth/sms", {
    template : "<sms/>"
  })
    .when("/auth/verify", {
    template : "<verify/>"
  })
    .otherwise({
      "template": "404 Page not found"
  })
});


        