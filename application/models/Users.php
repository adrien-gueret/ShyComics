<?php
	class Model_Users extends EntityPHP\Entity
	{
		protected static $table_name = 'users';

		protected $username;
		protected $email;
		protected $date_subscription;
		protected $is_email_verified;
		protected $password;
		protected $locale_website;
		protected $user_group;
		protected $friends;
		protected $locales_comics;
		
		const	DEFAULT_USERS_GROUP_ID = 1,
				DEFAULT_LOCALE_WEBSITE_ID = 1;

		public function __construct(
			$username = null, $email = null, $password = null,
			Model_UsersGroups $user_group = null,
			Model_Locales $locale_website = null
		) {
			$this->username = $username;
			$this->email = $email;
			$this->date_subscription = $_SERVER['REQUEST_TIME'];
			$this->is_email_verified = false;
			$this->password = Library_String::hash($password);
			$this->user_group = $user_group ?: Model_UsersGroups::getById(self::DEFAULT_USERS_GROUP_ID);
			$this->locale_website = $locale_website ?: Model_Locales::getById(self::DEFAULT_LOCALE_WEBSITE_ID);
			$this->friends = [];
			$this->locales_comics = [];
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
				'locale_website' => 'Model_Locales',
				'friends' => array('Model_Users'),
				'locales_comics' => array('Model_Locales'),
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

		public function isConnected()
		{
			return $this->getId() > 0;
		}
		
		public function getDocuments($id_parent = null)
		{
			$request	=	Model_Files::createRequest(true);
			$where		=	'user.id=? AND parent_file.id';
			$params		=	[$this->getId()];

			if(empty($id_parent))
				$where	.=	' IS NULL';
			else
			{
				$where		.=	'=?';
				$params[]	=	$id_parent;
			}

			return $request
						->where($where, $params)
						->orderBy('is_dir DESC')
						->exec();
		}
		
		public function getFolders($id_parent = null)
		{
			$request	=	Model_Files::createRequest(true);
			$where		=	'user.id=? AND parent_file.is_dir=? AND parent_file.id';
			$params		=	[$this->getId(), 1];

			if(empty($id_parent))
				$where	.=	' IS NULL';
			else
			{
				$where		.=	'=?';
				$params[]	=	$id_parent;
			}

			return $request->where($where, $params)->exec();
		}
		
		public function getFilesDirsAll()
		{
			$request = Model_Files::createRequest(true);
			$files = $request->where('user.id=? AND is_dir=?', [$this->getId(), 1])
							 ->exec();
			$files = $files->getArray();
			
			return empty($files) ? [] : $files;
		}

		public function can($permission)
		{
			if(empty($permission)) {
				return false;
			}

			return $this->user_group->getPermission($permission);
		}
	}
