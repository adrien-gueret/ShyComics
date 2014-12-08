<?php
	class Model_UsersGroups extends EntityPHP\Entity
	{
		protected $name;
		protected $can_remove;
		
		protected static $table_name = 'users_groups';
		
		public function __construct($name = null, $can_remove = null)
		{
			$this->name = $name;
			$this->can_remove = $can_remove;
		}
		
		public static function __structure()
		{
			return [
				'name' => 'VARCHAR(255)',
				'can_remove' => 'TINYINT(1)'
			];
		}
		
		public static function getByPermission($permission)
		{
			$request = Model_UsersGroups::createRequest();
			$results = $request->where('?=1', [$permission])
							   ->exec();
			return $results;
		}
	}
?>
