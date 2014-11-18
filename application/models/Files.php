<?php
	class Model_Files extends EntityPHP\Entity
	{
		protected $name;
		protected $description;
		protected $is_dir;
		protected $user;
		protected $parent_file;
		
		const PROCESS_OK = 0,
			  ERROR_UPLOAD = 1,
			  ERROR_SIZE = 2;
		
		protected static $table_name = 'files';
		
		public function __construct($name = null, $description = null, $is_dir = null, $user = null, $parent_file = null)
		{
			$this->name = $name;
			$this->description = $description;
			$this->is_dir = $is_dir;
			$this->user = $user;
			$this->parent_file = $parent_file;
		}
		
		public static function __structure()
		{
			return [
				'name' => 'VARCHAR(255)',
				'description' => 'TEXT',
				'is_dir' => 'TINYINT',
				'parent_file' => 'Model_Files',
				'user' => 'Model_Users',
			];
		}
		
		public static function getPath($id_user, $id_file)
		{
			//On renvoit le chemin correspond à si l'image est un .jpg, un .jpeg, un .png ou un .gif
			$pathPNG = 'public/users_files/galleries/' . $id_user . '/' . $id_file . '.png';
			$pathJPG = 'public/users_files/galleries/' . $id_user . '/' . $id_file . '.jpg';
			$pathJPEG = 'public/users_files/galleries/' . $id_user . '/' . $id_file . '.jpeg';
			$pathGIF = 'public/users_files/galleries/' . $id_user . '/' . $id_file . '.gif';
			$path = (is_file($pathPNG)) ? $pathPNG : ((is_file($pathJPG)) ? $pathJPG : ((is_file($pathJPEG)) ? $pathJPEG : ((is_file($pathGIF)) ? $pathGIF : null)));
			return $path;
		}
		
		public static function addFile($name = null, $description = null, $parent_file = null)
		{
			if(isset($_FILES['file']) AND $_FILES['file']['error'] == 0)
			{
				if($_FILES['file']['size'] <= 100000000)
				{
					$name = htmlspecialchars($name, ENT_QUOTES, 'utf-8');
					$description = htmlspecialchars($description, ENT_QUOTES, 'utf-8');
					$is_dir = 0;
					$user = Model_Users::getById($_SESSION['connected_user_id']);
					$parent_file = empty($parent_file) ? null : Model_Files::getById(intval($parent_file));
					
					$file = new Model_Files($name, $description, $is_dir, $user, $parent_file);
					$file = Model_Files::add($file);
					$fileID = $file->getId();
					
					$infosfile = pathinfo($_FILES['file']['name']);
					$extension_upload = $infosfile['extension'];
					$extensions_granted = array('jpg', 'jpeg', 'gif', 'png');
					
					$urldir = 'public/users_files/galleries/' . $_SESSION['connected_user_id'];
					$urlfile = 'public/users_files/galleries/' . $_SESSION['connected_user_id'] . '/' . $fileID . '.' . $extension_upload;
					if(!is_dir($urldir))
					{
						mkdir($urldir);
						chmod($urldir,0777);
					}
					
					if(in_array($extension_upload, $extensions_granted))
					{
						move_uploaded_file($_FILES['file']['tmp_name'], $urlfile);
						echo "L'envoi a bien été effectué !";
					}
					
					return self::PROCESS_OK;
				}
				else
				{
					return self::ERROR_SIZE;
				}
			}
			else
			{
				return self::ERROR_UPLOAD;
			}
		}
		
		public static function addDir($name = null, $description = null, $parent_file = null)
		{
			$name = htmlspecialchars($name, ENT_QUOTES, 'utf-8');
			$description = htmlspecialchars($description, ENT_QUOTES, 'utf-8');
			$is_dir = 1;
			$user = Model_Users::getById($_SESSION['connected_user_id']);
			$parent_file = empty($parent_file) ? null : Model_Files::getById(intval($parent_file));
			
			$file = new Model_Files($name, $description, $is_dir, $user, $parent_file);
			$file = Model_Files::add($file);
			$fileID = $file->getId();
			
			echo "L'envoi a bien été effectué !";
			
			return self::PROCESS_OK;
		}
	}
?>
