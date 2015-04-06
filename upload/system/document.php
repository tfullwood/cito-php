<?php
final class Document {
	private $file;
	private $class;
	private $styles = array();
	private $scripts = array();
	
	public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
		$this->styles[md5($href)] = array(
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
		);
	}
	
	public function getStyles() {
		return $this->styles;
	}	
	
	public function addScript($script) {
		$this->scripts[md5($script)] = $script;			
	}
	
	public function getScripts() {
		return $this->scripts;
	}
	
	public function loadModel($model) {
		$file  = DIR_ROOT . 'model/' . $model . '.php';
		$model = ucfirst($model);
		$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);
		
		if (file_exists($file)) { 
			include_once($file);
			return new $class();
		} else {
			trigger_error('Error: Could not load model ' . $model . '!');
			exit();					
		}
	}
	
	public function getFile() {
		return $this->file;
	}
	
	public function getClass() {
		return $this->class;
	}
	
}
?>