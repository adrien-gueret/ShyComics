<?php
	class Model_Files extends EntityPHP\Entity
	{
		protected $name;
		protected $description;
		protected $is_dir;
		protected $user;
		protected $parent_file;
		protected $liked_users;
		protected $tags;
		
		const 	SIZE_LIMIT		=	100000000,

				PROCESS_OK		=	1,
			  	ERROR_SIZE		=	2,
				ERROR_TYPE		=	3,
				ERROR_SAVE		=	4,
				ERROR_THUMB		=	5;
				
		
		protected static $table_name = 'files';
		
		public function __construct($name = null, $description = null, $is_dir = null, Model_Users $user = null, Model_Files $parent_file = null, $tags = null)
		{
			$this->name = $name;
			$this->description = $description;
			$this->is_dir = $is_dir;
			$this->user = $user;
			$this->parent_file = $parent_file;
			$this->liked_users = [];
			$this->tags = $tags;
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
				'tags' => ['Model_Tags'],
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
		
		public static function addFile(Model_Users $user, Array $fileData, $thumbnail_data_url, $name, $description = null, Model_Files $parent = null, $tags = null)
		{
			if($fileData['size'] > self::SIZE_LIMIT)
				return self::ERROR_SIZE;

			$user_id		=	$user->getId();
			$is_dir			=	0;
			
			//We manage the tags
			if(!empty($tags))
			{
				$arrayTags	=	explode(' ', $tags);
				$arrayNewTags = [];
				
				if(strpos($tags, ' ') === false)//Only 1 tag
				{
					$tagAlreadyExist = Model_Tags::getTag($tags);
					if(empty($tagAlreadyExist))
					{
						$newTag = new Model_Tags($tags);
						Model_Tags::add($newTag);
						$arrayTagsInstances = [$newTag];
					}
					else
						$arrayTagsInstances = [$tagAlreadyExist];
				}
				else//More than 1 tag
				{
					$tagsAlreadyExist = Model_Tags::getExistingTags($tags);
					$namesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return $tag->name;}, $tagsAlreadyExist) : [];
					$instancesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return Model_Tags::getTag($tag->name);}, $tagsAlreadyExist) : [];
					
					$tagsDontExist = array_diff($arrayTags, $namesTagsAlreadyExist);
					$instancesTagsDontExist = array_map(function($tagName){return new Model_Tags($tagName);}, $tagsDontExist);
					if(!empty($tagsDontExist))
						(count($tagsDontExist) == 1) ? Model_Tags::add(reset($instancesTagsDontExist)) : Model_Tags::addMultiple($instancesTagsDontExist);
					
					$arrayTagsInstances = array_merge($instancesTagsAlreadyExist, $instancesTagsDontExist);
				}
			}
			
			$file 		=	new Model_Files($name, $description, $is_dir, $user, $parent, $arrayTagsInstances);

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

			//Not forget to update the feed for followers
			$feed = new Model_Feed($user, $file_id, 0);
			Model_Feed::add($feed);

			return self::PROCESS_OK;
		}
		
		public static function addFolder(Model_Users $user, $name = null, $description = null, Model_Files $parent = null, $tags = null)
		{
			//We manage the tags
			if(!empty($tags))
			{
				$arrayTags	=	explode(' ', $tags);
				$arrayNewTags = [];
				
				if(strpos($tags, ' ') === false)//Only 1 tag
				{
					$tagAlreadyExist = Model_Tags::getTag($tags);
					if(empty($tagAlreadyExist))
					{
						$newTag = new Model_Tags($tags);
						Model_Tags::add($newTag);
						$arrayTagsInstances = [$newTag];
					}
					else
						$arrayTagsInstances = [$tagAlreadyExist];
				}
				else//More than 1 tag
				{
					$tagsAlreadyExist = Model_Tags::getExistingTags($tags);
					$namesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return $tag->name;}, $tagsAlreadyExist) : [];
					$instancesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return Model_Tags::getTag($tag->name);}, $tagsAlreadyExist) : [];
					
					$tagsDontExist = array_diff($arrayTags, $namesTagsAlreadyExist);
					$instancesTagsDontExist = array_map(function($tagName){return new Model_Tags($tagName);}, $tagsDontExist);
					if(!empty($tagsDontExist))
						(count($tagsDontExist) == 1) ? Model_Tags::add(reset($instancesTagsDontExist)) : Model_Tags::addMultiple($instancesTagsDontExist);
					
					$arrayTagsInstances = array_merge($instancesTagsAlreadyExist, $instancesTagsDontExist);
				}
			}
			
			$folder	=	new Model_Files($name, $description, 1, $user, $parent, $arrayTagsInstances);
			$newFolder = Model_Files::add($folder);

			//Not forget to update the feed for followers
			$feed = new Model_Feed($user, $newFolder->getId(), 0);
			Model_Feed::add($feed);

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

		public function getNbrOfLikes()
		{
			return $this->load('liked_users')->count();
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
		
		public static function search($string)
		{
			$string = trim($string);
			if(empty($string))
				return '';//Returns string so it activates is_array() in the view (empty request)
			
			$searchArray = explode(' ', htmlspecialchars($string));

			$like = implode("%' OR f.name LIKE '%", $searchArray);
			$in = implode(',', $searchArray);

			$results = \EntityPHP\EntityRequest::executeSQL("
				SELECT DISTINCT f.*
				FROM files f
				LEFT JOIN files2tags ft ON ft.id_files=f.id
				LEFT JOIN tags t ON t.id=ft.id_tags
				WHERE f.name LIKE '%" . $like . "%' OR t.name IN ('" . $in . "')
			");
			return $results;
		}
		
		public static function getLastBoards($number)
		{
			$request = Model_Files::createRequest();
			$results = $request->select('*')
							   ->where('is_dir=?', [false])
							   ->getOnly($number)
							   ->exec();
			
			return $results;
		}
		
		public static function getRandom()
		{
			$result = \EntityPHP\EntityRequest::executeSQL("
				SELECT *
				FROM files
				WHERE is_dir = false
				ORDER BY RAND() LIMIT 1
			");
			return Model_Files::getById($result[0]->id);
		}
		
		public function getPrevious()
		{
			$request = Model_Files::createRequest(true);
			
			$where		=	'id < ? AND is_dir=? AND parent_file.id';
			$params		=	[$this->getId(), false];
			$parentId = $this->getParentFileId();

			if(empty($parentId))
			{
				$where	.=	' IS NULL AND user.id=?';
				$params[]	=	$this->getUser()->getId();
			}
			else
			{
				$where		.=	'=?';
				$params[]	=	$parentId;
			}
			
			$result = $request->select('*')
							  ->where($where, $params)
						      ->orderBy('id DESC')
						      ->getOnly(1)
						      ->exec();
			return $result;
		}
		
		public function getNext()
		{
			$request = Model_Files::createRequest(true);
			
			$where		=	'id > ? AND is_dir=? AND parent_file.id';
			$params		=	[$this->getId(), false];
			$parentId = $this->getParentFileId();

			if(empty($parentId))
			{
				$where	.=	' IS NULL AND user.id=?';
				$params[]	=	$this->getUser()->getId();
			}
			else
			{
				$where		.=	'=?';
				$params[]	=	$parentId;
			}
			
			$result = $request->select('*')
							  ->where($where, $params)
						      ->orderBy('id')
						      ->getOnly(1)
						      ->exec();
			return $result;
		}
	}
