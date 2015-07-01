<?php
	class Model_Universes extends EntityPHP\Entity
	{
		protected static $table_name = 'universes';
		
		protected $name;
		
		public function __construct($name = null)
		{
			$this->name = $name;
		}
		
		public static function __structure()
		{
			return [
				'name' => 'VARCHAR(255)',
			];
		}
		
		public static function getAllUniverses()
		{
			$request = self::createRequest();
			$results = $request->exec();
			return $results;
		}
	}
?>