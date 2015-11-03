<?php  
class ControllerExampleSeo extends Controller {
	public function index() {
		//Pass variables to children
		$this->child_data = array();
		
		//Set up all the data to pass to the header
		$header_data = array();
		$header_data['title'] = 'Cito PHP | SEO Friendly URLs Page';
		
		//Push the header data to pass to the child controller classes
		$this->child_data['common/header'] = $header_data;
		//End child variables
		
		//Check and set the view
		if (file_exists(DIR_ROOT . '/view/template/example/seo.php')) {
			$this->template = 'example/seo.php';
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