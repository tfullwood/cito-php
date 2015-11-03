<?php
abstract class Controller {
	protected $document = array();
	protected $template;
	protected $data = array();
	protected $children = array();
	protected $output;
  protected $url;
	
	public function __construct($document = array()) {
		$this->document = $document;
    
    $this->url = $this->document->loadModel('common/url');
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
	
  //Render the page
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
			return "Error: Page failed to load. Talk to your webmaster if it continues.";
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
  
  protected function getUrl($route, $pid = NULL, $args = NULL) {    
    //Check if seo urls is enabled    
    if (URL_ALIAS == '1') {
      $url_data = $this->url->getUrl($route, $pid);
      
      //Read additional parameters and prepare string
      $url_args = '';
      $i = 0;
      if (is_array($args)) {
        foreach ($args as $key => $val) {
          if ($i == 0) {
            $url_args .= '?';
          } else {
            $url_args .= '&';
          }
          
          $url_args .= $key . '=' . $val;
          
          $i++;
        }
      } else {
        $url_args = $args;
      }
      
      //Check if it returned a keyword, return error if no keyword
      if (isset($url_data['query']) && $url_data['query'] != NULL) {
        $url = HTTP_SERVER . $url_data['keyword'] . $url_args;
      } else {
        $url = HTTP_SERVER . 'error';
      }
      
      return $url;
    } else {
      //Return the non seo url path
      
      //Read additional parameters and prepare string
      $url_args = '';
      if (is_array($args)) {
        foreach ($args as $key => $val) {
          $url_args .= '&' . $key . '=' . $val;
        }
      } else {
        $url_args = $args;
      }
      
      //Write the path to return
      $url = HTTP_SERVER . 'index.php?route=' . $route;
      
      if ($pid != NULL && $pid != '') {
        $url .= '&pid=' . $pid;
      }
      
      if ($url_args != '') {
        $url .= $url_args;
      }
      
      return  $url;
    }
  }
}
?>