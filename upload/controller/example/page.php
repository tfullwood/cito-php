<?php  
class ControllerExamplePage extends Controller {
	public function index() {
		//Pass variables to children
		$this->child_data = array();
		
    /*
    If you have url_alias enabled and you would like to create a blog, 
    newsletter, or some other page that will have dynamic content. 
    You'll call $this->document->url_id to get the id associated with 
    the content. An example of this can be found on the blog (blog/blog).
    
    Otherwise use a get parameter, e.g. below
    
    index.php?route=blog/blog&id=123
    */
    
    /*
    //Load the model
    $model = $this->document->loadModel('example/page');
    
    //Call method
    $data = $model->example();
    $this->data['testing'] = $data;
    
    Then display on the view via echo $testing;
    */
    
		//Set up all the data to pass to the header
		$header_data = array();
		$header_data['title'] = 'Cito PHP | Example Page';
		
		//Push the header data to pass to the child controller classes
		$this->child_data['common/header'] = $header_data;
		//End child variables
		
		//Check and set the view
		if (file_exists(DIR_ROOT . '/view/template/example/page.php')) {
			$this->template = 'example/page.php';
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