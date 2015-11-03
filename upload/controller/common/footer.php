<?php  
class ControllerCommonFooter extends Controller {
	public function index() {
		//Check for the view and set it
		if (file_exists(DIR_ROOT . 'view/template/common/footer.php')) {
			$this->template = 'common/footer.php';
		} else {
			$this->template = 'error/error.php';
		}
		
		return $this->render();
	}
}
?>