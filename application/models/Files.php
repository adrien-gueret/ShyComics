<?php
	class Model_Files extends EntityPHP\Entity
	{
		protected $name;
		protected $description;
		protected $is_dir;
		protected $user;
		protected $parent_file;
		
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
	}
?>
