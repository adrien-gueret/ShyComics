<?php
	class Model_Genres extends EntityPHP\Entity
	{
		protected static $table_name = 'genres';
		
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
		
		public static function getAllGenres()
		{
			$request = self::createRequest();
			$results = $request->exec();
			return $results;
		}
	}
?>