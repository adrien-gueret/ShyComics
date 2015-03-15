<?php
	class Model_Comments extends EntityPHP\Entity
	{
		protected static $table_name = 'comments';

		protected $user;
		protected $content;
		protected $file;
		
		const	COMMENT_SUCCESS = 1;

		public function __construct(Model_Users $user = null, $content = null, Model_Files $file = null)
		{
			$this->user = $user;
			$this->content = $content;
			$this->file = $file;
		}
		
		public static function __structure()
		{
			return [
				'user' => 'Model_Users',
				'content' => 'VARCHAR(255)',
				'file' => 'Model_Files',
			];
		}

		public function getUser()
		{
			return $this->load('user');
		}
	}
