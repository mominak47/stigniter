<?php


/*
    You should start the path with "dashboard/*" if the module has interface on dashboard.
*/

$routes->get('dashboard/finance', '\Modules\Finance\Controllers\Finance::index');