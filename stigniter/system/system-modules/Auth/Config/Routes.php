<?php
$routes->get('auth/signin', '\SystemModules\Auth\Controllers\Auth::index');
$routes->get('auth/login', '\SystemModules\Auth\Controllers\Auth::index');
$routes->get('auth', '\SystemModules\auth\Controllers\Auth::index');
$routes->get('auth/create', '\SystemModules\Auth\Controllers\Auth::register');
$routes->get('auth/register', '\SystemModules\Auth\Controllers\Auth::register');
$routes->get('auth/password', '\SystemModules\Auth\Controllers\Auth::password');
$routes->get('register', '\SystemModules\auth\Controllers\Auth::register');
$routes->get('auth/translations', '\SystemModules\Auth\Controllers\Auth::translations');
$routes->get('auth/sms', '\SystemModules\auth\Controllers\SMS::index');
$routes->get('auth/verify', '\SystemModules\auth\Controllers\Verify::index');
