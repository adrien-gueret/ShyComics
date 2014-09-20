<?php
	class Model_Files extends EntityPHP\Entity
	{
		protected $name;
		protected $description;
		
		protected static $table_name = 'files';
		
		public function __construct($name = null, $description = null, $is_dir = null)
		{
			$this->name = $name;
			$this->description = $description;
			$this->is_dir = $is_dir;
		}
		
		public static function __structure()
		{
			return [
				'name' => 'VARCHAR(255)',
				'description' => 'TEXT',
				'is_dir' => 'TINYINT',
				'parent_file' => 'Model_Files',
				'user' => 'Model_Users',
			];
		}
	}
?>
