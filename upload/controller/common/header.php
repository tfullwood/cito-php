<?php  
class ControllerCommonHeader extends Controller {
	public function index($input) {
		//Loop through all input variables and allow view access
		foreach ($input as $key => $val) {
			$this->data[$key] = $val;
		}
		
		//Set up get styles and scripts
		$this->document->addStyle('view/styles/styles.css', 'stylesheet', 'screen');
		$this->data['styles'] = $this->document->getStyles();
		
		$this->document->addScript('view/scripts/scripts.js');
		$this->data['scripts'] = $this->document->getScripts();
		
		//Check for the view and set it
		if (file_exists(DIR_ROOT . 'view/template/common/header.php')) {
			$this->template = 'common/header.php';
		} else {
			$this->template = 'error/error.php';
		}
		
		return $this->render();
	}
}
?>