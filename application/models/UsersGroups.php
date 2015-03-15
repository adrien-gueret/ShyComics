<?php
	class Model_UsersGroups extends EntityPHP\Entity
	{
		protected static $table_name = 'users_groups';

		protected $name;
		/* Permissions */
		protected $can_remove_other_files = 0;

		const PERM_REMOVE_OTHERS_FILES	=	'can_remove_other_files';

		public function __construct($name = null, Array $permissions = [])
		{
			$this->name = $name;

			foreach($permissions as $name => $value)
			{
				if(isset($this->$name))
					$this->$name	=	$value;
			}
		}
		
		public static function __structure()
		{
			return [
				'name' => 'VARCHAR(255)',
				'can_remove_other_files' => 'TINYINT(1)'
			];
		}

		public function getPermission($permission)
		{
			return empty($this->$permission) ? false : true;
		}
	}