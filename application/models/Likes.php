<?php
	class Model_Likes extends EntityPHP\Entity
	{
		protected $user;
		protected $file;
		
		const	PROCESS_OK = 0,
				ERROR_USER = 1,
				ERROR_FILE = 2,
				ERROR_ALREADY = 3;
		
		protected static $table_name = 'likes';
		
		public function __construct($user = null, $file = null)
		{
			$this->user = $user;
			$this->file = $file;
		}
		
		public static function __structure()
		{
			return [
				'user' => 'Model_Users',
				'file' => 'Model_Files',
			];
		}
		
		public static function hasLiked(Model_Users $user, Model_Files $file)
		{
			$request = Model_Likes::createRequest();
			$results = $request->where('user.id=? AND file.id=?', [$user->getId(), $file->getId()])
							   ->getOnly(1)
							   ->exec();

			return ! empty($results);
		}
		
		public static function addLike(Model_Users $user, Model_Files $file)
		{
			if(empty($user))
				return self::ERROR_USER;
			
			if(empty($file))
				return self::ERROR_FILE;
			
			if(Model_Likes::hasLiked($user, $file))
				return self::ERROR_ALREADY;
			
			$like = new Model_Likes($user, $file);
			Model_Likes::add($like);
			
			return self::PROCESS_OK;
		}
	}
?>
