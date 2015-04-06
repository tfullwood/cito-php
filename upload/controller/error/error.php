<?php  
class ControllerErrorError extends Controller {
	public function index() {
		//Pass variables to children
		$this->child_data = array();
		
		//Set up all the data to pass to the header
		$header_data = array();
		$header_data['title'] = 'Wrong turn bro...';
		
		//Push the header data to pass to the child controller classes
		$this->child_data['header'] = $header_data;
		//End child variables
		
		
		if (file_exists(DIR_ROOT . '/view/template/error/error.php')) {
			$this->template = 'error/error.php';
		} else {
			$this->template = 'error/error.php';
		}
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		return $this->render();
	}
	
}
?>