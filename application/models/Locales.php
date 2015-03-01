<?php
	class Model_Locales extends EntityPHP\Entity
	{
		protected static $table_name = 'locales';

		protected $name;

		public function __construct($name = null)
		{
			$this->name	=	$name;
		}
		
		public static function __structure()
		{
			return [
				'name' => 'VARCHAR(10)',
			];
		}
	}
