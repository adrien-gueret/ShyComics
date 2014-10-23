<?php
	class Controller_spritecomics_index extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics',
			]);
			
			$view	=	\Eliya\Tpl::get('spritecomics/index');
			$this->response->set($view);
		}
		
		public function get_add()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Ajouter du contenu',
			]);
			
			$view	=	\Eliya\Tpl::get('spritecomics/add');
			$this->response->set($view);
		}
		
		public function post_addFile()
		{
			if(isset($_FILES['file']) AND $_FILES['file']['error'] == 0)
			{
				if($_FILES['file']['size'] <= 100000000)
				{
						$name = htmlspecialchars($POST['name'], ENT_QUOTES, 'utf-8');
						$description = htmlspecialchars($POST['description'], ENT_QUOTES, 'utf-8');
						$is_dir = 0;
						$user = $_SESSION['connected_user_id'];
						$parent_file = intval($POST['parent_file']);
						
						$file = new Model_Files($name, $description, $is_dir, $user, $parent_file);
						$file = Model_Files::add($file);
						$fileID = $file->getId();
						
						$infosfile = pathinfo($_FILES['file']['name']);
						$extension_upload = $infosfile['file'];
						$extensions_granted = array('jpg', 'jpeg', 'gif', 'png');
						if(in_array($extension_upload, $extensions_granted))
						{
							move_uploaded_file($_FILES['file']['tmp_name'], 'http://localhost/ShyComics/public/users_files/galeries/' . $_SESSION['connected_user_id'] . '/' . $fileID . '.' . $extension_upload . '');
							echo "L'envoi a bien été effectué !";
						}
				}
				else
				{
					echo "Erreur &bull; Le document dépasse la limite de taille/mémoire imposée.";
				}
			}
			else
			{
				echo "Erreur &bull; Le document n'a pas, ou a mal, été envoyé. Une erreur est donc survenue. Veuillez réessayer.";
			}
		}
	}