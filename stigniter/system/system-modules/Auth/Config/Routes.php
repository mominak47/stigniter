<?php

/*
    You should start the path with "dashboard/*" if the module has interface on dashboard.
*/

$routes->get('auth/signin', '\SystemModules\Auth\Controllers\Auth::index');
$routes->get('auth/login', '\SystemModules\Auth\Controllers\Auth::index');
$routes->get('auth', '\SystemModules\Auth\Controllers\Auth::index');


$routes->get('auth/create', '\SystemModules\Auth\Controllers\Auth::register');
$routes->get('auth/register', '\SystemModules\Auth\Controllers\Auth::register');

$routes->get('auth/password', '\SystemModules\Auth\Controllers\Auth::password');

$routes->get('register', '\SystemModules\Auth\Controllers\Auth::register');

$routes->get('auth/translations', '\SystemModules\Auth\Controllers\Auth::translations');
