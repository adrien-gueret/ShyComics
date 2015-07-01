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

				PROCESS_OK		=	1,
			  	ERROR_SIZE		=	2,
				ERROR_TYPE		=	3,
				ERROR_SAVE		=	4,
				ERROR_THUMB		=	5,
				
				DEFAULT_UNIVERSE_ID = 1,
				DEFAULT_GENRE_ID = 1;
				
		
		protected static $table_name = 'files';
		
		public function __construct($name = null, $description = null, $is_dir = null, $user = null, $parent_file = null, $universe = null, $genre = null)
		{
			$this->name = $name;
			$this->description = $description;
			$this->is_dir = $is_dir;
			$this->user = $user;
			$this->parent_file = $parent_file;
			$this->liked_users = [];
			$this->universe = $universe ?: Model_Universes::getById(self::DEFAULT_UNIVERSE_ID);
			$this->genre = $genre ?: Model_Genres::getById(self::DEFAULT_GENRE_ID);
		}
		
		public static function __structure()
		{
			return [
				'name' => 'VARCHAR(255)',
				'description' => 'TEXT',
				'is_dir' => 'BOOLEAN',
				'parent_file' => 'Model_Files',
				'user' => 'Model_Users',
				'liked_users' => ['Model_Users'],
				'universe' => 'Model_Universes',
				'genre' => 'Model_Genres',
			];
		}
		
		public function getPath()
		{
			//On renvoit le chemin correspond si l'image est un .jpg, un .jpeg, un .png ou un .gif
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

		public function getThumbPath()
		{
			$path = 'public/users_files/galleries/' . $this->prop('user')->getId() . '/' . $this->getId() . '.thumb.png';

			if(is_file($path))
				return $path;

			return null;
		}
		
		public static function addFile(Model_Users $user, Array $fileData, $thumbnail_data_url, $name, $description = null, Model_Files $parent = null)
		{
			if($fileData['size'] > self::SIZE_LIMIT)
				return self::ERROR_SIZE;

			$user_id		=	$user->getId();
			$is_dir			=	0;

			$file 		=	new Model_Files($name, $description, $is_dir, $user, $parent);

			$file 		=	Model_Files::add($file);
			$file_id	=	$file->getId();

			$infosfile			=	pathinfo($fileData['name']);
			$extension_upload	=	strtolower($infosfile['extension']);
			$extensions_granted	=	['jpg', 'jpeg', 'gif', 'png'];

			if( ! in_array($extension_upload, $extensions_granted))
			{
				Model_Files::delete($file);
				return self::ERROR_TYPE;
			}

			$url_dir	=	'public/users_files/galleries/' . $user_id;
			$url_file	=	'public/users_files/galleries/' . $user_id . '/' . $file_id . '.' . $extension_upload;
			$url_thumb	=	'public/users_files/galleries/' . $user_id . '/' . $file_id . '.thumb.png';

			if( ! is_dir($url_dir))
			{
				mkdir($url_dir);
				chmod($url_dir, 0777);
			}

			if( ! move_uploaded_file($fileData['tmp_name'], $url_file))
			{
				Model_Files::delete($file);
				return self::ERROR_SAVE;
			}

			//Now we can generate the thumbnail !
			$image_data	=	substr($thumbnail_data_url, strpos($thumbnail_data_url, ',') + 1);
			$resource	=	imagecreatefromstring(base64_decode($image_data));

			if( ! imagepng($resource, $url_thumb))
				return self::ERROR_THUMB;

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
				//Unlink physical file
				$path	=	$this->getPath();

				if( ! is_file($path))
					throw new Exception(Library_i18n::get('spritecomics.delete.errors.not_found'), 404);

				if( ! unlink($path))
					throw new Exception(Library_i18n::get('spritecomics.delete.errors.unlink_failed'), 500);

				//And remove its thumbnail
				$path	=	$this->getThumbPath();
				
				//Remove likes
				$this->liked_users = [];
				Model_Files::update($this);
				
				//And remove comments
				$comments	=	$this->getComments();

				foreach($comments as $comment)
					Model_Comments::delete($comment);

				if( ! is_file($path))
					throw new Exception(Library_i18n::get('spritecomics.delete.errors.thumb_not_found'), 404);

				if( ! unlink($path))
					throw new Exception(Library_i18n::get('spritecomics.delete.errors.thumb_unlink_failed'), 500);

			}
			else
			{
				$children	=	$this->getChildren();

				foreach($children as $child)
					$child->unlink();
			}

			self::delete($this);
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

		public function isLikedByUser(Model_Users $user)
		{
			$liked_users	=	$this->load('liked_users');

			return $liked_users->hasEntity($user);
		}
		
		public function getComments()
		{
			if($this->is_dir)
				return [];

			$request = Model_Comments::createRequest();
			$results = $request->where('file.id=?', [$this->getId()])
							   ->exec();
			return $results;
		}
	}
