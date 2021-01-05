
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
    .when("/auth/register", {
    template : "<register/>"
  })
  });


        