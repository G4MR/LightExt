<?php
error_reporting(E_ALL);

require "Boot/Autoload.php";
require "Vendor/Functions.php";

$pathinfo 					= pathinfo($_SERVER['PHP_SELF']);
$dirname 					= trim(preg_replace('/^\/|\/$/', '', $pathinfo['dirname']));
$_SERVER['REQUEST_URI'] 	= !empty($dirname) ? str_replace('/' . $dirname, '', $_SERVER['REQUEST_URI']) : $_SERVER['REQUEST_URI'];

$k = new Klein\Klein();

$k->respond('/hello-world/[**:params]?/?', function($req, $res) {
	// echo 'testing';
	echo $req->params;
	echo 'in here';
});

$k->dispatch();


//$LE = new LightExt();
// $route = new LightExt\Router();
// $route->get_route();
// $route->dispatch();

// return false;
// echo 'test';

// try {
// 	$LE->load_modules();
// } catch(\Exceptions\NotFound $e) {
// 	echo $e->error404();
// } catch(Exception $e) {
// 	echo $e->getMessage();
// }