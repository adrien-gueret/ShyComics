<?php
	class Model_Files extends EntityPHP\Entity
	{
		protected $name;
		protected $description;
		protected $is_dir;
		protected $user;
		protected $parent_file;
		protected $liked_users;
		
		const 	SIZE_LIMIT		=	100000000,

				PROCESS_OK		=	0,
			  	ERROR_UPLOAD	=	1,
			  	ERROR_SIZE		=	2,
				ERROR_TYPE		=	3,
				ERROR_SAVE		=	4,

				LIKE_PROCESS_OK		=	5,
				LIKE_ERROR_CONNECTED_USER = 6,
				LIKE_ERROR_SAME_USER = 7,
				LIKE_ERROR_FILE = 8,
				LIKE_ERROR_ALREADY = 9;
		
		protected static $table_name = 'files';
		
		public function __construct($name = null, $description = null, $is_dir = null, $user = null, $parent_file = null)
		{
			$this->name = $name;
			$this->description = $description;
			$this->is_dir = $is_dir;
			$this->user = $user;
			$this->parent_file = $parent_file;
			$this->liked_users = array();
		}
		
		public static function __structure()
		{
			return [
				'name' => 'VARCHAR(255)',
				'description' => 'TEXT',
				'is_dir' => 'BOOLEAN',
				'parent_file' => 'Model_Files',
				'user' => 'Model_Users',
				'liked_users' => array('Model_Users'),
			];
		}
		
		public function getPath()
		{
			//On renvoit le chemin correspond à si l'image est un .jpg, un .jpeg, un .png ou un .gif
			$extensions = ['png', 'jpg', 'jpeg', 'gif'];
			$base_path = 'public/users_files/galleries/' . $this->prop('user')->getId() . '/' . $this->getId() . '.';

			foreach($extensions as $extension)
			{
				$path = $base_path.$extension;

				if(is_file($path))
					return $path;
			}

			return null;
		}
		
		public static function addFile(Model_Users $user, $name = null, $description = null, Model_Files $parent = null)
		{
			if( ! isset($_FILES['file']) || $_FILES['file']['error'] != 0)
				return self::ERROR_UPLOAD;

			if($_FILES['file']['size'] > self::SIZE_LIMIT)
				return self::ERROR_SIZE;

			$user_id		=	$user->getId();
			$is_dir			=	0;

			$file 		=	new Model_Files($name, $description, $is_dir, $user, $parent);

			$file 		=	Model_Files::add($file);
			$file_id	=	$file->getId();

			$infosfile			=	pathinfo($_FILES['file']['name']);
			$extension_upload	=	strtolower($infosfile['extension']);
			$extensions_granted	=	['jpg', 'jpeg', 'gif', 'png'];

			if( ! in_array($extension_upload, $extensions_granted))
			{
				Model_Files::delete($file);
				return self::ERROR_TYPE;
			}

			$url_dir	=	'public/users_files/galleries/' . $user_id;
			$url_file	=	'public/users_files/galleries/' . $user_id . '/' . $file_id . '.' . $extension_upload;

			if( ! is_dir($url_dir))
			{
				mkdir($url_dir);
				chmod($url_dir, 0777);
			}

			if( ! move_uploaded_file($_FILES['file']['tmp_name'], $url_file))
			{
				Model_Files::delete($file);
				return self::ERROR_SAVE;
			}

			return self::PROCESS_OK;
		}
		
		public static function addFolder(Model_Users $user, $name = null, $description = null, Model_Files $parent = null)
		{
			$folder	=	new Model_Files($name, $description, 1, $user, $parent);
			Model_Files::add($folder);

			return self::PROCESS_OK;
		}

		public function unlink()
		{
			if($this->is_dir == 0)
			{
				$path	=	$this->getPath();

				if( ! is_file($path))
					throw new Exception('L\'image n\'a pas pu être trouvée. Veuillez réessayer ou prévenir un administrateur.', 404);

				if( ! unlink($path))
					throw new Exception('Erreur lors de la suppresion du fichier. Veuillez réessayer ou prévenir un administrateur.', 500);

			}
			else
			{
				$children	=	$this->getChildren();

				foreach($children as $child)
					$child->unlink();
			}

			self::delete($this);
		}

		public function deletePhysicalFile()
		{
			$path	=	$this->getPath();

			if( ! is_file($path))
				throw new Exception('L\'image n\'a pas pu être trouvée. Veuillez réessayer ou prévenir un administrateur.', 404);

			if( ! unlink($path))
				throw new Exception('Erreur lors de la suppresion du fichier. Veuillez réessayer ou prévenir un administrateur.', 500);

			return $this;
		}
		
		public function getUser()
		{
			return $this->load('user');
		}

		public function getChildren()
		{
			if( ! $this->is_dir)
				return [];

			return self::createRequest()
					->where('parent_file.id=?', [$this->getId()])
					->exec();
		}
		
		public function getParentFile()
		{
			return $this->load('parent_file');
		}
		
		public function getParentFileId()
		{
			$request = Model_Files::createRequest();
			$results = $request->select('parent_file.id')
							   ->where('id=?', [$this->getId()])
							   ->getOnly(1)
							   ->exec();

			return empty($results->parent_file_id) ? null : $results->parent_file_id;
		}
		
		public static function addLike(Model_Users $user, Model_Files $file)
		{
			if(empty($user))
				return self::ERROR_USER;
			
			if(empty($file))
				return self::ERROR_FILE;
			
			$already_liked = $file->load('liked_users')->liked_users->hasEntity($user);
			if($alreadyLiked)
				return self::ERROR_ALREADY;
			
			$file->prop('liked_users')[] = $user;
			Model_Files::update($file);
			
			return self::PROCESS_OK;
		}
	}
