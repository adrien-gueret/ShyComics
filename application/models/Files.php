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
		protected $sub_date;
		
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
			$this->sub_date = date('Y-m-d');
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
				'sub_date' => 'DATE',
			];
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
		
		public function getParentFileName()
		{
			$request = Model_Files::createRequest();
			$results = $request->select('parent_file.name')
							   ->where('id=?', [$this->getId()])
							   ->getOnly(1)
							   ->exec();

			return empty($results->parent_file_name) ? null : $results->parent_file_name;
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
		
		public function getViews()
		{
			if($this->is_dir)
				return [];

			$request = Model_Views::createRequest();
			$results = $request->where('document.id=?', [$this->getId()])
							   ->exec();
			return $results;
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
				
				$tagsAlreadyExist = Model_Tags::getExistingTags($tags);
                $namesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return $tag->name;}, $tagsAlreadyExist) : [];
                $instancesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return Model_Tags::getTag($tag->name);}, $tagsAlreadyExist) : [];
                
                $tagsDontExist = array_diff($arrayTags, $namesTagsAlreadyExist);
                $instancesTagsDontExist = array_map(function($tagName){return new Model_Tags($tagName);}, $tagsDontExist);
                if(!empty($tagsDontExist))
                    Model_Tags::addMultiple($instancesTagsDontExist);
                
                $arrayTagsInstances = array_merge($instancesTagsAlreadyExist, $instancesTagsDontExist);
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
				
				$tagsAlreadyExist = Model_Tags::getExistingTags($tags);
                $namesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return $tag->name;}, $tagsAlreadyExist) : [];
                $instancesTagsAlreadyExist = (is_array($tagsAlreadyExist)) ? array_map(function($tag){return Model_Tags::getTag($tag->name);}, $tagsAlreadyExist) : [];
                
                $tagsDontExist = array_diff($arrayTags, $namesTagsAlreadyExist);
                $instancesTagsDontExist = array_map(function($tagName){return new Model_Tags($tagName);}, $tagsDontExist);
                if(!empty($tagsDontExist))
                    Model_Tags::addMultiple($instancesTagsDontExist);
                
                $arrayTagsInstances = array_merge($instancesTagsAlreadyExist, $instancesTagsDontExist);
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
                
                if(file_exists($path))
                {
                    unlink($path);
                }
                
				/*
				if( ! is_file($path))
				{
					$this->response->error(Library_i18n::get('spritecomics.delete.file.errors.not_found'), 404);
					return;
				}
                if( ! unlink($path))
				{
					$this->response->error(Library_i18n::get('spritecomics.delete.file.errors.unlink_failed'), 500);
					return;
				}*/

				//And remove its thumbnail
				$path	=	$this->getThumbPath();
                
                if(file_exists($path))
                {
                    unlink($path);
                }

				/*if( ! is_file($path))
				{
					$this->response->error(Library_i18n::get('spritecomics.delete.file.errors.thumb_not_found'), 404);
					return;
				}

				if( ! unlink($path))
				{
					$this->response->error(Library_i18n::get('spritecomics.delete.file.errors.thumb_unlink_failed'), 500);
					return;
				}*/
				
				//Remove likes
				$this->prop('liked_users', []);
				
				//Remove comments
				$comments	=	$this->getComments();

				foreach($comments as $comment)
					Model_Comments::delete($comment);
				
				//And remove feed
				$feeds	=	$this->getFeeds();

				foreach($feeds as $feed)
					Model_Feed::delete($feed);

				//Remove views
				$views = $this->getViews();

				foreach($views as $view)
					Model_Views::delete($view);
					
				//And remove tags
				$this->prop('tags', []);

				Model_Files::update($this);

			}
			else
			{
				//Remove tags
				$this->prop('tags', []);

				Model_Files::update($this);
				
				//And remove all children of this dir
				$children	=	$this->getChildren();

				foreach($children as $child)
					$child->unlink();
			}

			self::delete($this);
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

		public function getFeeds()
		{
			if($this->is_dir)
				return [];
  
			$request = Model_Feed::createRequest();
			$results = $request->where('object=? AND type IN (?, ?, ?)', [$this->getId(), Model_Feed::OBJECT_IS_A_SENT_FILE, Model_Feed::OBJECT_IS_A_LIKED_FILE, Model_Feed::OBJECT_IS_A_COMMENTARY])
							   ->exec();
			return $results;
		}
    
		public static function search($string, $search_files = false, $search_dirs = false, $search_users = false)
		{
			$string = trim($string);
			if(empty($string))
				return ['', '', ''];//Returns empty strings so it activates is_array() in the view (empty request)
			
			$searchArray = explode(' ', htmlspecialchars($string, ENT_QUOTES));
            $searchArray = array_filter($searchArray, 'strlen');

			$flike = implode("%' OR f.name LIKE '%", $searchArray);
			$ulike = implode("%' OR username LIKE '%", $searchArray);
			$in = implode("', '", $searchArray);
            
            if($search_users)
            {
                $resultsUsers = \EntityPHP\EntityRequest::executeSQL("
                    SELECT id, username
                    FROM users
                    WHERE username LIKE '%" . $ulike . "%'
                ");
            }
            else
                $resultsUsers = "";

			if($search_dirs)
            {
                $resultsDirs = \EntityPHP\EntityRequest::executeSQL("
                    SELECT DISTINCT f.*
                    FROM files f
                    LEFT JOIN files2tags ft ON ft.id_files=f.id
                    LEFT JOIN tags t ON t.id=ft.id_tags
                    JOIN users u ON u.id=f.id_user
                    WHERE f.is_dir = true AND (f.name LIKE '%" . $flike . "%' OR t.name IN ('" . $in . "'))
                ");
            }
            else
                $resultsDirs = "";
            
			if($search_files)
            {
                $resultsFiles = \EntityPHP\EntityRequest::executeSQL("
                    SELECT DISTINCT f.*
                    FROM files f
                    LEFT JOIN files2tags ft ON ft.id_files=f.id
                    LEFT JOIN tags t ON t.id=ft.id_tags
                    JOIN users u ON u.id=f.id_user
                    WHERE f.is_dir = false AND (f.name LIKE '%" . $flike . "%' OR t.name IN ('" . $in . "'))
                ");
            }
            else
                $resultsFiles = "";
            
			return [$resultsUsers, $resultsFiles, $resultsDirs];
		}
		
		public static function getLastBoards($number)
		{
			$request = Model_Files::createRequest();
			$results = $request->select('*')
							   ->where('is_dir=?', [false])
							   ->getOnly($number)
                               ->orderBy('id DESC')
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
			return (is_array($result)) ? Model_Files::getById($result[0]->id) : null;
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
		
		public static function getPopulars($nbr = 10)
		{
			$result = \EntityPHP\EntityRequest::executeSQL("
				SELECT id, DATEDIFF(NOW(), sub_date) AS sub_datediff, (SELECT COUNT(*) FROM comments c WHERE c.id_file = f.id) AS nbr_comms,
					(SELECT COUNT(*) FROM views v WHERE v.id_document = f.id) AS nbr_views, (SELECT COUNT(*) FROM files2liked_users f2l WHERE f2l.id_files = f.id) AS nbr_likes
				FROM files f
				WHERE is_dir = false
				ORDER BY (1000 - sub_datediff * 100) + nbr_comms * 10 + (nbr_views + nbr_likes) * 5 DESC
				LIMIT 10
			");
			
			return $result;
		}
	}
