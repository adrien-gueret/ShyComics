<?php
	class Controller_spritecomics_add extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics',
			]);
			
			$view	=	\Eliya\Tpl::get('spritecomics/index');
			$this->response->set($view);
		}
		
		public function post_index($name = null, $description = null, $parent_file = null)
		{
			if(isset($_FILES['file']) AND $_FILES['file']['error'] == 0 AND isset($_SESSION['connected_user_id']) AND !empty($_SESSION['connected_user_id']))
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
						
						$member = Model_Users::getById($_SESSION['connected_user_id']);
						
						\Eliya\Tpl::set([
							'page_title'		=>	'Sprites Comics &bull; Galerie',
						]);
						
						if(!empty($member))
						{
							$data = [
								'user_id'		=> $member->prop('id'),
								'user_name'		=> $member->prop('username'),
								'user_files'	=> $member->getFiles(),
							];
						}
						else
						{
							$data = [
								'user_id'		=> null,
								'user_name'		=> null,
								'user_files'	=> null,
							];
						}
						
						$view	=	\Eliya\Tpl::get('spritecomics/gallery', $data);
						$this->response->set($view);
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