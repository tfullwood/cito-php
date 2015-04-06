<?php
class Log {
	private $filename;
	
	public function __construct($filename) {
		$this->filename = $filename;
	}
	
	public function write($path, $message) {
		$file = DIR_ROOT . $this->filename;

		$handle = fopen($file, 'a+');
		
		$message = date('Y-m-d G:i:s') . ' - ' . $path . ' - ' . $message . "\r\n";
		
		fwrite($handle, $message);
		
		fclose($handle);
	}
	
	public function getPage($full = 0) {
		if ($full = 'full') {
			$path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];
			return $path;
		} else {
			$path = $_SERVER['REQUEST_URI'];
			return $path;
		}
	}
}
?>