<?php  
class ModelCommonUrl extends Model {
	public $sql;
	
  //Gets url data based on a keyword search
  public function getKeyword($keyword) {
    $keyword = $this->escape($keyword);
    
    $query = $this->query('SELECT * FROM `url_alias` WHERE `keyword` = "' . $keyword . '"');
    $query = $query->row;
    
    return $query;
  }
  
  //Gets url data based on the route and parameter
  public function getUrl($route, $pid) {
    $route = $this->escape($route);
    $pid = $this->escape($pid);
    
    $query = $this->query('SELECT * FROM `url_alias` WHERE `query` = "' . $route . '" AND `parameter` = "' . $pid . '" LIMIT 1');
    $query = $query->row;
    
    return $query;
  }
}
?>