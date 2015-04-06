<?php
abstract class Controller {
	protected $document = array();
	protected $template;
	protected $data = array();
	protected $children = array();
	protected $output;
	
	public function __construct($document = array()) {
		$this->document = $document;
	}
	
	protected function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url));
		exit();
	}
	
	protected function getChild($child, $args = array()) {
		$action = new Action($child, $args);

		if (file_exists($action->getFile())) {
			require_once($action->getFile());
			
			$class = $action->getClass();
			
			$controller = new $class($this->document);
			
			$controller->{$action->getMethod()}($action->getArgs());
			
			return $controller->output;
		} else {
			$log->write($log->getPage(), 'Failed to load child controller ' . $child);
			exit();
		}
	}
	
	protected function render() {
		foreach ($this->children as $child) {
			$child_name = str_replace('/', '_', $child);
			
			
			if (isset($this->child_data[$child])) {
				$this->data[$child_name] = $this->getChild($child, $this->child_data[$child]);
			} else {
				$this->data[$child_name] = $this->getChild($child);
			}
		}
		
		if (file_exists(DIR_ROOT . 'view/template/' . $this->template)) {
			foreach ($this->data as $key => $val) {
				${$key} = $val;
			}
			
			ob_start();
			
			require(DIR_ROOT . 'view/template/' . $this->template);
			
			$this->output = ob_get_contents();

			ob_end_clean();

			return $this->output;
			
		} else {
			$log->write($log->getPage(), 'Controller render() failed to load template');
			return "Error: Page failed to load. Talk to Trevor if it continues.";
		}
	}
	
	//Check get parameters
	protected function get($param) {
		if (isset($_GET[$param])) {
			return $_GET[$param];
		} else {
			return '';
		}
	}
	
}
?>