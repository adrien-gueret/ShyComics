<?php
	class Model_UsersGroups extends EntityPHP\Entity
	{
		protected static $table_name = 'users_groups';

		protected $name;
		/* Permissions */
		protected $can_remove_other_files = 0;
		protected $can_edit_other_file_s_desc = 0;
		protected $can_edit_other_file_s_tags = 0;
		protected $can_remove_other_comments = 0;
		protected $can_edit_other_comments = 0;

		const PERM_REMOVE_OTHERS_FILES		=	'can_remove_other_files';
		const PERM_EDIT_OTHERS_TAGS		=	'can_edit_other_file_s_tags';
		const PERM_EDIT_OTHERS_DESCS		=	'can_edit_other_file_s_desc';
		const PERM_REMOVE_OTHERS_COMMENTS	=	'can_remove_other_comments';
		const PERM_EDIT_OTHERS_COMMENTS	=	'can_edit_other_comments';

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
				'can_remove_other_files' => 'TINYINT(1)',
				'can_edit_other_file_s_tags' => 'TINYINT(1)',
				'can_edit_other_file_s_desc' => 'TINYINT(1)',
				'can_remove_other_comments' => 'TINYINT(1)',
				'can_edit_other_comments' => 'TINYINT(1)'
			];
		}

		public function getPermission($permission)
		{
			return empty($this->$permission) ? false : true;
		}
	}