<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

// Hook untuk logging error otomatis
$hook['pre_system'] = array(
    'class'    => 'Log_errors',
    'function' => '',
    'filename' => 'Log_errors.php',
    'filepath' => 'hooks'
);
