<?php
	class Model_Friends extends EntityPHP\Entity
	{
		protected $id_friend1;
		protected $id_friend2;
		
		protected static $table_name = 'friends';
		
		public function __construct($id_friend1 = null, $id_friend2 = null)
		{
			$this->friend1 = $id_friend1;
			$this->friend2 = $id_friend2;
		}
		
		public static function __structure()
		{
			return [
				'friend1' => 'Model_Users',
				'friend2' => 'Model_Users',
			];
		}
	}
?>
