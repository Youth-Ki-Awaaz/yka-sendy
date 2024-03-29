<?php

/*
* Plugin Name: YKA Sendy
* Plugin URI: https://sputznik.com
* Description: Plugin to manage subscription on Sendy Server
* Version: 2.0.0
* Author: Jay Vardhan
* Author URI: https://sputznik.com
*/

if (!defined('ABSPATH')) {
	exit;
}

//constant to change js and css version
define('YKA_SENDY_VERSION', '2.0.0');


$inc_files = array(
	'admin-settings.php',
	'class-yka-sendy-base.php',
	'subscription/class-element-builder.php',
	'subscription/class-yka-sendy-subscription.php',
);

foreach ($inc_files as $file) {
	require_once($file);
}
