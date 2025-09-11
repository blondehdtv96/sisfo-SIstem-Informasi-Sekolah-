<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
*/

$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Authentication routes
$route['login'] = 'auth/index';
$route['logout'] = 'auth/logout';

// Dashboard routes
$route['dashboard'] = 'dashboard/index';

// Master Data routes
$route['matapelajaran'] = 'matapelajaran/index';
$route['matapelajaran/(:any)'] = 'matapelajaran/$1';

$route['tingkatan'] = 'tingkatan/index';
$route['tingkatan/(:any)'] = 'tingkatan/$1';

$route['jurusan'] = 'jurusan/index';
$route['jurusan/(:any)'] = 'jurusan/$1';

$route['kelas'] = 'kelas/index';
$route['kelas/(:any)'] = 'kelas/$1';

$route['tahunakademik'] = 'tahunakademik/index';
$route['tahunakademik/(:any)'] = 'tahunakademik/$1';

// Data Management routes  
$route['siswa'] = 'siswa/index';
$route['siswa/(:any)'] = 'siswa/$1';

$route['guru'] = 'guru/index';
$route['guru/(:any)'] = 'guru/$1';

$route['walikelas'] = 'walikelas/index';
$route['walikelas/(:any)'] = 'walikelas/$1';

$route['user'] = 'user/index';
$route['user/(:any)'] = 'user/$1';

// Report routes
$route['laporan'] = 'laporan/index';
$route['laporan/(:any)'] = 'laporan/$1';

// Settings routes
$route['profile'] = 'profile/index';
$route['change_password'] = 'profile/change_password';