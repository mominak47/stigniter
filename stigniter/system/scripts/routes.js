
app.config(function($routeProvider) {
  $routeProvider
    .when("/", {
    template : "<login/>"
  })
    .when("/auth/register", {
    template : "<register/>"
  })
  });


        