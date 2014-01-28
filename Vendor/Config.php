<?php

/**
 * LightExt - Config
 *
 * Load Config File Data
 */

class Config {

	static public function __($config_name) {

		$config 	= @explode(".", $config_name);
		
		if(!empty($config)) {

			//first we need to popoff the last array value because that's our config options
			$config_option 	= end($config);

			array_pop($config);

			foreach($config as $key => $val) {
				$config[$key] = ucfirst(strtolower($val));
			}

			//structure the path of the config option
			$path 	= dirname(__DIR__) . "/Boot/Config/" . implode("/", $config) . ".php";

			//make sure the file exists
			if(file_exists($path)) {

				//load config data into a variable
				$config_data 	= include_once ($path);

				//make sure it's the correct data
				if(!is_array($config_data)) 
					return null;

				//lets make sure the option we're looking for exists
				if(!isset($config_data[$config_option]))
					return null;

				return $config_data[$config_option];
			}
		}

		return null;

	}

	static public function all($config_parts) {

		$config_tmp = array();
		$config 	= @explode(".", $config_parts);

		foreach($config as $key => $item) {
			$item 	= trim($item);
			if(!empty($item)) $config_tmp[] = ucfirst(strtolower($item));
		}

		$config = $config_tmp;
		
		//make sure we aren't dealing with a dud array
		if(!empty($config)) {

			$path 	= dirname(__DIR__) . "/Boot/Config/" . implode("/", $config) . ".php";

			if(file_exists($path)) {

				//lets try loading the file array into the variable
				$config_data 	= include_once ($path);

				//lets make sure we got the correct data
				if(!is_array($config_data))
					return null;

				return $config_data;
			}
		}

		return null;
	}
}