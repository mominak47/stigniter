
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
    .when("/grocery", {
    template : "<grocery/>"
  })
    .when("/finance", {
    template : "<finance/>"
  })
    .when("/jobs", {
    template : "<jobs/>"
  })
  });


        