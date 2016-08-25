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
		protected $follows;
		protected $locales_comics;
		
		const	DEFAULT_USERS_GROUP_ID		=	1,
				DEFAULT_LOCALE_WEBSITE_ID	=	1,

				LIKE_SUCCESS				=	1,
				ERROR_LIKE_ALREADY_LIKE		=	2,
				ERROR_LIKE_USER_IS_OWNER	=	3,
				
				UNLIKE_SUCCESS				=	1,
				ERROR_LIKE_DOES_NOT_EXIST	=	2,
				
				WIDTH_LIMIT		=	130,
				HEIGHT_LIMIT		=	150,

				PROCESS_OK		=	1,
			  	ERROR_SIZE		=	2,
				ERROR_TYPE		=	3,
				ERROR_SAVE		=	4;
				

		public function __construct(
			$username = null, $email = null, $password = null,
			Model_Locales $locale_website = null,
			Model_UsersGroups $user_group = null
		) {
			$this->username = $username;
			$this->email = $email;
			$this->date_subscription = $_SERVER['REQUEST_TIME'];
			$this->is_email_verified = false;
			$this->password = Library_String::hash($password);
			$this->locale_website = $locale_website ?: Model_Locales::getById(self::DEFAULT_LOCALE_WEBSITE_ID);
			$this->user_group = $user_group ?: Model_UsersGroups::getById(self::DEFAULT_USERS_GROUP_ID);
			$this->follows = [];
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
				'about' => 'VARCHAR(255)',
				'user_group' => 'Model_UsersGroups',
				'locale_website' => 'Model_Locales',
				'follows' => array('Model_Users'),
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

		public static function getByUsername($username)
		{
			$request = Model_Users::createRequest();
			$results = $request->where('username=?', [$username])
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
		
		public function getAvatarURL()
		{
			//On renvoit le chemin correspond si l'image est un .jpg, un .jpeg, un .png ou un .gif
			$extensions = ['png', 'jpg', 'jpeg', 'gif'];
			$base_path = 'public/users_files/avatars/' . $this->getId() . '.';

			foreach($extensions as $extension)
			{
				$path = $base_path.$extension;

				if(is_file($path))
					return $path;
			}

			return 'public/users_files/avatars/default.png';
		}

		public function can($permission)
		{
			if(empty($permission)) {
				return false;
			}

			return $this->user_group->getPermission($permission);
		}

		public function like(Model_Files $file)
		{
			if($file->isLikedByUser($this))
				return self::ERROR_LIKE_ALREADY_LIKE;

			if($this->equals($file->getUser()))
				return self::ERROR_LIKE_USER_IS_OWNER;
			
			$file->load('liked_users')->push($this);
			$file->load('parent_file');
			$file->load('tags');
			
			Model_Files::update($file);
			
			//Not forget to update the feed for followers
			$feed = new Model_Feed($this, $file->getId(), 1);
			Model_Feed::add($feed);

			return self::LIKE_SUCCESS;
		}

		public function unlike(Model_Files $file)
		{
			if(!$file->isLikedByUser($this))
				return self::ERROR_LIKE_DOES_NOT_EXIST;

			$file->load('liked_users')->remove($this);
			$file->load('parent_file');
			$file->load('tags');
			$file->load('user');

			Model_Files::update($file);

			return self::UNLIKE_SUCCESS;
		}
		
		public function changeAvatar(Array $fileData)
		{
			list($width, $height) = getimagesize($fileData['tmp_name']);
			
			if($width > self::WIDTH_LIMIT || $height > self::HEIGHT_LIMIT)
				return self::ERROR_SIZE;

			$infosfile			=	pathinfo($fileData['name']);
			$extension_upload	=	strtolower($infosfile['extension']);
			$extensions_granted	=	['jpg', 'jpeg', 'gif', 'png'];
			
			if( ! in_array($extension_upload, $extensions_granted))
			{
				return self::ERROR_TYPE;
			}
			
			$url_file	=	'public/users_files/avatars/' . $this->getId() . '.' . $extension_upload;
			
			if( ! move_uploaded_file($fileData['tmp_name'], $url_file))
			{
				return self::ERROR_SAVE;
			}
			
			return self::PROCESS_OK;
		}
		
		public function changeAbout($content)
		{
			$this->prop('about', $content);
			Model_Users::update($this);
			
			return self::PROCESS_OK;
		}

		public function isFollowedByUser(Model_Users $user)
		{
			$follows	=	$user->load('follows');

			return $follows->hasEntity($this);
		}
		
		public function follow(Model_Users $user)
		{
			if( ! $user->isFollowedByUser($this) && ! $this->equals($user))
			{
				$this->load('follows')->push($user);
				
				Model_Users::update($this);
			}
		}
		
		public function unfollow(Model_Users $user)
		{
			if($user->isFollowedByUser($this))
			{
				$this->load('follows')->remove($user);
				
				Model_Users::update($this);
			}
		}
		
		public function hasViewedFileToday(Model_Files $document)
		{
			$view = Model_Views::createRequest()
					->where('document.id=? AND user.id=?', [$document->getId(), $this->getId()])
					->orderBy('date DESC')
					->getOnly(1)
					->exec();
			
			if(!$view)
				return false;
			else
			{
				$date = date('Y-m-d H:i:s');
				$dateNow = new DateTime($date);
				$dateView = new DateTime($view->prop('date'));
				
				$interval = $dateView->diff($dateNow)->format('%a');
				return $interval == 0;
			}
		}

		public function getFeed()
		{
			$arrayFollows = [];
			foreach($this->prop('follows') as $key => $follow)
			{
				$arrayFollows[] = $follow->getId();
			}

			$follows = implode(',', $arrayFollows);

			$results = \EntityPHP\EntityRequest::executeSQL("
				SELECT f.*, u.username
				FROM feed f
				LEFT JOIN users u ON f.id_author=u.id
				WHERE f.id_author IN ('" . $follows . "')
				ORDER BY f.id DESC
				LIMIT 0,20
			");

			return is_array($results)?$results:null;
		}
		
		public function getSubDate()
		{
			$datetime = $this->prop('date_subscription');
			return date_format(date_create($datetime), "d/m/Y"); 
		}
	}
