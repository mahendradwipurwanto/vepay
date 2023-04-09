<?php
defined('BASEPATH') or exit('No direct script access allowed');

// AUTHENTICATION
$route['sign-in'] = 'authentication';
$route['login'] = 'authentication';
$route['sign-up'] = 'authentication/signUp';
$route['register'] = 'authentication/signUp';
$route['sign-out'] = 'authentication/logout';
$route['logout'] = 'authentication/logout';
$route['offline'] = 'authentication/offline';
$route['lupa-password'] = 'authentication/forgotPassword';
$route['reset-password/(:any)'] = 'authentication/ubah_password/$1';
$route['verifikasi-email/(:any)'] = 'authentication/verifikasi_email/$1';

// ADMIN
$route['admin/dashboard'] = 'admin';
$route['admin/vcc-member'] = 'admin/vcc_member';
$route['master/metode-pembayaran'] = 'master/metode';
$route['master/metode-withdraw'] = 'master/withdraw';

// DEFAULT
$route['default_controller'] = 'authentication';
$route['404_override'] = 'utility/not_found';
$route['translate_uri_dashes'] = false;
