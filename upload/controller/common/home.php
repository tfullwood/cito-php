<?php  
class ControllerCommonHome extends Controller {
	public function index() {
		//Pass variables to children
		$this->child_data = array();
		
		//Set up all the data to pass to the header
		$header_data = array();
		$header_data['title'] = 'Cito PHP | Lightweight PHP MVC Framework';
		
		//Push the header data to pass to the child controller classes
		$this->child_data['common/header'] = $header_data;
		//End child variables
		
		//Check and set the view
		if (file_exists(DIR_ROOT . '/view/template/common/home.php')) {
			$this->template = 'common/home.php';
		} else {
			$this->template = 'error/error.php';
		}
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		//return $this->render($data);
		return $this->render();
	}
	
	//Sample update function
	public function update() {
		/*
		The default function called is index. However you can call another function in the path parameter. Just add another argument,
		index.php?route=common/home will call the index, index.php?route=common/home/update will call this function.
		*/
		
		//Pass variables to children
		$this->child_data = array();
		
		//Set up all the data to pass to the header
		$header_data = array();
		$header_data['title'] = 'Page Title';
		
		//Push the header data to pass to the child controller classes
		$this->child_data['common/header'] = $header_data;
		//End child variables
		
		//Check and set the view
		if (file_exists(DIR_ROOT . '/view/template/common/home.php')) {
			$this->template = 'common/home.php';
		} else {
			$this->template = 'common/error.php';
		}
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		return $this->render();
	}	
}
?>