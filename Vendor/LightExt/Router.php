<?php

namespace LightExt;

class Router {

	/**
	 * Allow us to skip the dispatcher if needed
	 */
	private $skip 	= false;

	/**
	 * Routes that were set
	 */
	private $routes = array();

	/**
	 * Request object
	 */
	public $request = null;

	/**
	 * Setup defaults
	 *
	 * @return void
	 */
	public function __construct() {

		//setup request variable
		$this->request = new \stdClass;

		//setup request method
		$this->request->method = $this->get_request_method();

		//ajax request
		$this->request->isAjax = $this->is_ajax();
	}

	/**
	 * Register a route
	 * 
	 * @param string $route - path that we are maping
	 * @param function $callback - callback function that we are mapping our route to
	 * @param string $request_type - request type we are limited the data to, default = all
	 * @return void
	 */
	public function map($route, $callback, $request_type = null) {
		$this->routes[] = array($route, $callback, $request_type);
	}

	public function dispatch() {

		//skip the dispatcher from calling any routes
		if($this->skip) return null;

		print_r($_SERVER);
		echo $this->get_route();
	}

	/**
	 * Get the current route path being called
	 *
	 * @return string
	 */
	public function get_route() {

		//need to trim slashes from the beginning/end for later use
		$request_uri = preg_replace('/^\/|\/$/', '', $_SERVER['REQUEST_URI']);
		
		//get rid of exceeding forward slashes that append behind one another
		$request_uri = preg_replace('/\/+/', '/', $request_uri);

		//get directory path to be removed
		$pathinfo 	= pathinfo($_SERVER['PHP_SELF']);
		$dirname 	= preg_replace('/^\/|\/$/', '', $pathinfo['dirname']);
		
		//remove directory path from request uri
		$request_uri = preg_replace('/^' . preg_quote($dirname, '/') . '/i', '', $request_uri);
		
		//trim slashes from the beginning/end
		$request_uri = preg_replace('/^\/|\/$/', '', $request_uri);

		//remove _GET data
		$request_uri = preg_replace('/\?.*/', '', $request_uri);

		//remove some invalid characters
		$request_uri = preg_replace('/[\?\#\$\(\)\[\]\.\*\&\^\%\#\@\<\>\,\!]/i', '', $request_uri);

		return $request_uri;
	}

	/**
	 * Get the request method ex.: GET, POST, PUT, etc...
	 *
	 * @return string
	 */
	public function get_request_method() {
		if(isset($_SERVER['REQUEST_METHOD'])) {
			return $_SERVER['REQUEST_METHOD'];
		}
	}

	/**
	 * Checks if this is an ajax request
	 *
	 * @return boolean
	 */
	public function is_ajax() {
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && preg_match("/xmlhttprequest/i", $_SERVER['HTTP_X_REQUESTED_WITH']))
			return true;
		return false;
	}

	/**
	 * check $skip
	 *
	 * @return void
	 */
	public function skip() {
		$this->skip = true;
	}
}