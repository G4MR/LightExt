<?php

class LightExt {
	
	/**
	 * Slim Framework instance
	 */
	public $slim = null;

	public $klein = null;

	/**
	 * Basically skip everything after this action, manual
	 * routing.
	 */
	public $override = false;

	/**
	 * Module Directory
	 */
	public $module_dir 	= null;

	/**
	 * Light Extension Default Admin panel directory path
	 */
	// public $admin_dir_path = null;

	/**
	 * Light Extension Default Admin Modules
	 */
	// public $admin_module_default_class 	= null;
	// public $admin_module_default_method = null;

	public function __construct() {

		//setup slim instance
		$this->slim = new \Slim\Slim();

		$this->klein = new \Klein\Klein();

		//setup settings
		$this->module_dir 	= Config::__('paths.default-module-directory');

		// $this->admin_dir_path 				= Config::__("app.admin-dir");
		// $this->admin_module_default_class 	= Config::__("app.admin-default-module-class");
		// $this->admin_module_default_method 	= Config::__("app.admin-default-module-method");
		
		
	}

	public function load_modules() {

		//alias variables
		$skip 		= false;
		$slim 		=& $this->slim;
		$req 		= $slim->request;
		$override 	=& $this->override;
		$routes 	= \Config::all('routes');

		//setup override -> Config.Routes.php
		foreach($routes as $route => $class_info) {

			//skip if the data is incomplete
			if(empty($route) || empty($class_info)) continue;

			//lets validate the route & class existance
			$class 	= @explode("@", $class_info);

			//needs to be put into 2 parts before and after the @
			if(count($class) != 2) continue;

			//lets check if file exists
			$class_parts = @explode('.', $class[0]);

			//get class path
			$class_path = base_path($this->module_dir . '/' . implode('/', $class_parts) . '.php');

			if(!file_exists($class_path))
				continue;

			//module class name
			$class_name = implode('\\', $class_parts) . '_Module';

			//include module class
			require_once $class_path;

			if(!class_exists($class_name))
				continue;

			$class_method = $class[1];

			if(!method_exists($class_name, $class_method) || !is_callable(array($class_name, $class_method)))
				continue;

			var_dump($slim->request->params());
			continue;
			$slim->map($route, function() use($class_name, $class_method, &$override) {



				//override everything that comes after this
				$override = true;
			})->via('GET', 'POST');

		}

		//stole this line from slim to solve a problem
		$matched_routes = $this->slim->router->getMatchedRoutes($this->slim->request->getMethod(), 
																$this->slim->request->getResourceUri());
		if(!empty($matched_routes))
			$this->slim->run();

		//setup autoload if nothing is overriding us
		if(!$this->override) {
			echo 'nothing is overriding us';
		}






		//throw new \Exceptions\NotFound("Couldn't find this module");

		//alias slim because you can't use $this as a lexical variable in that scope
		//$app =& $this->slim;

		// $req 	= $this->slim->request;
		// // echo $req->getRootUri() . "<br>";
		// // echo $req->getResourceUri();
		// // echo "<br>end";

		// $this->slim->get('/', function() {
		// 	//echo "testing 1";
		// });

		// $this->slim->get('/', function() {
		// 	// echo 'override';
		// });

	}
}