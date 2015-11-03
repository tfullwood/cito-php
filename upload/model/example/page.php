<?php  
class ModelExamplePage extends Model {
	public $sql;
	
	public function example() {
		return $this->query('SELECT * FROM `url_alias` WHERE `url_alias_id` = "1"');
	}
	
	public function anotherExample($data) {
		$sql = 'ANOTHER DB QUERY';
		$sql .= ' APPEND TO QUERY';
		
		return $this->query($sql);
	}
}
?>