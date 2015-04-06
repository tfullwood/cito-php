<?php
final class Action {
	protected $file;
	protected $class;
	protected $method;
	protected $args = array();

	public function __construct($route, $args = array()) {
		$path = '';
		
		$parts = explode('/', str_replace('../', '', (string)$route));
		
		foreach ($parts as $part) { 
			$path .= $part;
			
			if (is_dir(DIR_ROOT . 'controller/' . $path)) {
				$path .= '/';
				
				array_shift($parts);
				
				continue;
			}
			
			if (is_file(DIR_ROOT . 'controller/' . str_replace(array('../', '..\\', '..'), '', $path) . '.php')) {
				$this->file = DIR_ROOT . 'controller/' . str_replace(array('../', '..\\', '..'), '', $path) . '.php';
				
				$path = ucfirst($path);
				$this->class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $path);

				array_shift($parts);
				
				break;
			}
		}
		
		if ($args) {
			$this->args = $args;
		}
			
		$method = array_shift($parts);
		
		if ($method) {
			$this->method = $method;
		} else {
			$this->method = 'index';
		}
		
		if(!isset($this->file) || !is_file($this->file)) {
			$this->file = DIR_ROOT . 'controller/error/error.php';
			$this->class = "ControllerErrorError";
			$this->method = 'index';
		}
	}
	
	public function getFile() {
		return $this->file;
	}
	
	public function getClass() {
		return $this->class;
	}
	
	public function getMethod() {
		return $this->method;
	}
	
	public function getArgs() {
		return $this->args;
	}
}
?>