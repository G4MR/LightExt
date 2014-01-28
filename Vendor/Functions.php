<?php

function module_path($module, $admin = false) {

	$module 	= '/' . trim(preg_replace("/^\/|\/$", '', $module));

	if($admin == true) {
		return base_path(\Config::__('paths.admin-module-directory') . $module);
	}

	return base_path(\Config::__('paths.default-module-directory') . $module);
}


/**
 * Get the root directory of the LightExt framework
 *
 * @param string
 * @return string
 */
function base_path($path = null) {
	$path 	= trim(preg_replace("/^\/|\/$/", '', $path));
	return str_replace('\\', '/', dirname(__DIR__)) . '/' . $path;
}