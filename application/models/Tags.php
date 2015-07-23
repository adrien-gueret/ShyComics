<?php
	class Model_Tags extends EntityPHP\Entity
	{
		protected static $table_name = 'tags';
		
		protected $name;
		
		public function __construct($name = null)
		{
			$this->name = strtolower($name);
		}
		
		public static function __structure()
		{
			return [
				'name' => 'VARCHAR(255)',
			];
		}
		
		public static function getTag($name)
		{
			return self::createRequest()
					->where('name=?', [strtolower($name)])
					->getOnly(1)
					->exec();
		}
	}
?>