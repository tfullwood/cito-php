<?php  
class ModelExamplePage extends Model {
	public $sql;
	
	public function example() {
		return $this->query('YOUR DB QUERY');
	}
	
	public function anotherExample($data) {
		$sql = 'ANOTHER DB QUERY';
		$sql .= ' APPEND TO QUERY';
		
		return $this->query($sql);
	}
}
?>