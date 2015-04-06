<?php  
class ControllerCommonFooter extends Controller {
	public function index() {
		//I need to set up the title and the meta description
		
		if (file_exists(DIR_ROOT . 'view/template/common/footer.php')) {
			$this->template = 'common/footer.php';
		} else {
			$this->template = 'error/error.php';
		}
		
		return $this->render();
	}
}
?>