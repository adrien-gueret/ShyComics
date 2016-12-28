<?php
	class Model_Smileys extends EntityPHP\Entity
	{
		protected $tag;
		
		protected static $table_name = 'smileys';
		
		public function __construct($tag = null)
		{
			$this->tag = $tag;
		}
		
		public static function __structure()
		{
			return [
				'tag' => 'VARCHAR(15)',
			];
		}
		
		public function getPath()
		{
			return 'public/images/smileys/' . $this->getId() . '.gif';
		}
	}
