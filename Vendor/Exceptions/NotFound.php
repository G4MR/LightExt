<?php

namespace Exceptions;
class NotFound extends \Exception {
	public function error404() {
		echo $this->getMessage();
		echo "404 template loaded";
	}
}