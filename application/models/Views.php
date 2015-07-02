<?php
	class Model_Views extends EntityPHP\Entity
	{
		protected static $table_name = 'views';
		
		protected $date;
		protected $user;
		protected $document;
		
		public function __construct($date = null, Model_Users $user = null, Model_Files $document = null)
		{
			$this->date = $date;
			$this->user = $user;
			$this->document = $document;
		}
		
		public static function __structure()
		{
			return [
				'date' => 'DATETIME',
				'user' => 'Model_Users',
				'document' => 'Model_Files',
			];
		}
	}
?>