<?php

/*
    You should start the path with "dashboard/*" if the module has interface on dashboard.
*/

$routes->get('auth/signin', '\SystemModules\Auth\Controllers\Auth::index');
$routes->get('auth/login', '\SystemModules\Auth\Controllers\Auth::index');
$routes->get('auth', '\SystemModules\Auth\Controllers\Auth::index');