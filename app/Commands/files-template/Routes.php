<?php

/*
    You should start the path with "dashboard/*" if the module has interface on dashboard.
    Example Route :
    $routes->get('dashboard{slug}', '\{module-type}\{slug}\Controllers\{sanitized_title}::index');
*/

$routes->get('{slug}', '\{module-type}\{slug}\Controllers\{sanitized_title}::index');
