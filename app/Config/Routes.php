<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);  
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/prizes', 'Admin::prizes');
$routes->post('/admin/savePrize', 'Admin::savePrize');
$routes->get('/admin/deletePrize/(:num)', 'Admin::deletePrize/$1');

$routes->get('/admin/registrants', 'Admin::registrants');
$routes->post('/admin/reset-registrants', 'Admin::resetRegistrants');
$routes->get('/admin/winners', 'Admin::winners');
$routes->post('/admin/update-winner-status', 'Admin::updateWinnerStatus');
$routes->post('/admin/reset-winners', 'Admin::resetWinners');
$routes->get('/admin/raffle', 'Admin::raffle');

$routes->post('admin/save-winner', 'Admin::postSaveWinner');
$routes->post('admin/save-winner-batch', 'Admin::saveWinnerBatch');
$routes->post('admin/update-winner-batch', 'Admin::updateWinnerBatch');
$routes->get('/admin/select-prize', 'Admin::selectPrize');
$routes->post('/admin/savePrizeSelection', 'Admin::savePrizeSelection');

$routes->get('/admin/raffle-control', 'Admin::raffleControl');


$routes->get('/admin/select-grandprize', 'Admin::selectGrandPrize');
$routes->post('/admin/save-grand-prize-selection', 'Admin::saveGrandPrizeSelection');
$routes->get('admin/grandprize/(:num)', 'Admin::grandPrize/$1');
$routes->post('admin/post-save-winner', 'Admin::postSaveWinner');

$routes->get('admin/sync', 'Admin::syncGoogleSheet');

$routes->get('/', 'Home::index');
$routes->get('/register', 'Registration::index');
$routes->post('/register', 'Registration::submit');
$routes->get('/register/success', 'Registration::success');