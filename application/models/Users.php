<?php
	class Model_Users extends EntityPHP\Entity
	{
		protected $username;
		protected $email;
		protected $date_subscription;
		protected $is_email_verified;
		protected $password;
		protected $user_group;
		protected $friends;
		
		const DEFAULT_USERS_GROUP_ID = 1;
		
		protected static $table_name = 'users';
		
		public function __construct($username = null, $email = null, $password = null, $user_group = null)
		{
			$this->username = $username;
			$this->email = $email;
			$this->date_subscription = $_SERVER['REQUEST_TIME'];
			$this->is_email_verified = false;
			$this->password = Library_String::hash($password);
			$this->user_group = $user_group ?: Model_UsersGroups::getById(self::DEFAULT_USERS_GROUP_ID);
			$this->friends = [];
		}
		
		public static function __structure()
		{
			return [
				'username' => 'VARCHAR(255)',
				'email' => 'VARCHAR(254)',
				'is_email_verified' => 'BOOLEAN',
				'password' => 'CHAR(40)',
				'date_subscription' => 'DATETIME',
				'user_group' => 'Model_UsersGroups',
				'friends' => array('Model_Users'),
			];
		}
		
		public static function getByEmail($email)
		{
			$request = Model_Users::createRequest();
			$results = $request->where('email=?', [$email])
							   ->getOnly(1)
							   ->exec();
			return $results;
		}
		
		public static function emailVerified($id)
		{
			$user = Model_Users::getById($id);
			$user->prop('is_email_verified', 1);
			
			Model_Users::update($user);
		}
		
		public static function getForLogin($username, $password)
		{
			$user = Model_Users::createRequest();
			$results = $user->where('username=? AND password=? AND is_email_verified=?', [$username, $password, 1])
							->getOnly(1)
							->exec();
			return $results;
		}
		
		public function getFiles($id_folder = null)
		{
			$request = Model_Files::createRequest(true);
			if(empty($id_folder))
			{
				$files = $request->where('user.id=? AND parent_file.id IS NULL', [$this->getId()])
								 ->exec();
				$files = $files->getArray();
			}
			else
			{
				$files = $request->where('user.id=? AND parent_file.id=?', [$this->getId(), $id_folder])
								 ->exec();
				$files = $files->getArray();
			}
			
			return empty($files) ? [] : $files;
		}
		
		public function getFilesDirs($id_folder = null)
		{
			$request = Model_Files::createRequest(true);
			if(empty($id_folder))
			{
				$files = $request->where('user.id=? AND is_dir=? AND parent_file.id IS NULL', [$this->getId(), 1])
								 ->exec();
				$files = $files->getArray();
			}
			else
			{
				$files = $request->where('user.id=? AND is_dir=? AND parent_file.id=?', [$this->getId(), 1, $id_folder])
								 ->exec();
				$files = $files->getArray();
			}
			
			return empty($files) ? [] : $files;
		}
		
		public function getFilesDirsAll()
		{
			$request = Model_Files::createRequest(true);
			$files = $request->where('user.id=? AND is_dir=?', [$this->getId(), 1])
							 ->exec();
			$files = $files->getArray();
			
			return empty($files) ? [] : $files;
		}
		
		public static function removeFile($id = null)
		{
			$file = Model_Files::getById($id);
			Model_Files::delete($file);
		}
	}
?>
